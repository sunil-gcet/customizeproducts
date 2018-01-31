<?php

namespace Chilliapple\Customizeproducts\Model\Cdresource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData\CollectionFactory;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class CustomizeData
 *
 * @package Chilliapple\Customizeproducts\Model\Cdresource
 */
class CustomizeData extends AbstractDb
{

    protected $collectionFactory;

    /**
     * Define main table and key
     */
    protected function _construct()
    {
        $this->_init('customizeproducts_customizeproductsdefault', 'entity_id');
    }

    /**
     * CustomizeData constructor.
     *
     * @param Context $context
     * @param null|string $connectionName
     * @param $collectionFactory $categoryCollectionFactory
     */
    public function __construct(
        Context $context,
        $connectionName = null,
		CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $connectionName);

        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get customize data list form a given product id
     *
     * @param $productId
     *
     * @return \Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData\Collection
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomizeDataByProductId($productId)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            'id_product',
            (int)$productId
        );
		$collection->setPageSize(1);

        return $collection;
    }

}