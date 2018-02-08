<?php

namespace Chilliapple\Customizeproducts\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Chilliapple\Customizeproducts\Api\CustomizeDataRepositoryInterface as CustomizeDataRepositoryInterface;
use Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData\CollectionFactory;
use Chilliapple\Customizeproducts\Model\CustomizeDataFactory;
use Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData as CustomizeDataResource;
use Magento\Framework\Exception\CouldNotSaveException;
/**
 * Class CustomizeDataRepository
 * 
 * @package Chilliapple\Customizeproducts\Model
 */
class CustomizeDataRepository implements CustomizeDataRepositoryInterface
{

    /**
     * @var \Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface[]
     */
    protected $entities = [];

    /**
     * @var \Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface[]
     */
    protected $entitiesByProductId = [];

    /**
     * @var bool
     */
    protected $allLoaded = false;

    /**
     * @var \Chilliapple\Customizeproducts\Model\CustomizeDataFactory
     */
    protected $customizeDataFactory;

    /**
     * @var CollectionFactory
     */
    protected $customizeDataCollectionFactory;

    /**
     * @var CustomizeDataResource
     */
    protected $resource;

    /**
     * CustomizeDataRepository constructor.
     *
     * @param \Chilliapple\Customizeproducts\Model\CustomizeDataFactory $customizeDataFactory
     * @param CollectionFactory $customizeDataCollectionFactory
     * @param CustomizeData $customizeDataResource
     */
    public function __construct(
        CustomizeDataFactory $customizeDataFactory,
        CollectionFactory $customizeDataCollectionFactory,
        CustomizeDataResource $customizeDataResource
    ) {
        $this->customizeDataFactory = $customizeDataFactory;
        $this->customizeDataCollectionFactory = $customizeDataCollectionFactory;
        $this->resource = $customizeDataResource;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (isset($this->entities[$id])) {
            return $this->entities[$id];
        }

        $customizeData = $this
            ->customizeDataFactory
            ->create();

        $customizeData->load($id);

        if ($customizeData->getId() === null) {
            throw new NoSuchEntityException(__('Requested custom description is not found'));
        }

        $this->entities[$id] = $customizeData;

        return $customizeData;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        if (!$this->allLoaded) {
            /** @var $customizeDataCollection \Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData\Collection */
            $customizeDataCollection = $this
                ->customizeDataCollectionFactory
                ->create();

            foreach ($customizeDataCollection as $item) {
                $this->entities[$item->getId()] = $item;
                $this->entitiesByProductId[$item->getProductId()][] = $item;
            }

            $this->allLoaded = true;
        }

        return $this->entities;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomizeDataByProductId($productId)
    {
        if (isset($this->entitiesByProductId[$productId])) {
            return $this->entitiesByProductId[$productId];
        }

        $customizeDataFactory = $this
            ->customizeDataFactory
            ->create();

        $customizeDataCollection = $customizeDataFactory
            ->getCustomizeDataByProductId($productId);

        $this->entitiesByProductId[$productId] = $customizeDataCollection;

        return $customizeDataCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface $customizeData)
    {
        try {
            $this->resource->save($customizeData);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $customizeData;
    }
}
