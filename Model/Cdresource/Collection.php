<?php

namespace Chilliapple\Customizeproducts\Model\Cdresource;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * 
 * @package Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData
 */
class Collection extends AbstractCollection
{
    /**
     * Define model and resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Chilliapple\Customizeproducts\Model\Cdresource'
        );
    }
}