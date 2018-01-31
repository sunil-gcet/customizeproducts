<?php

namespace Chilliapple\Customizeproducts\Api;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Customize Data repository interface
 *
 * @api
 */
interface CustomizeDataRepositoryInterface
{

    /**
     * Retrieve customize data by id
     *
     * @param int $id
     * @return \Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface
     * @throws NoSuchEntityException
     */
    public function get($id);

    /**
     * Retrieve list of all customize data
     *
     * @return \Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface[]
     */
    public function getAll();

    /**
     * Retrieve list of customize data by product id
     *
     * @param int $productId
     * @return \Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface[]
     */
    public function getCustomizeDataByProductId($productId);

    /**
     * Save a custom data
     *
     * @param Data\CustomizeDataInterface $customDescription
     * @return \Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Chilliapple\Customizeproducts\Api\Data\CustomizeDataInterface $customizeData);

}