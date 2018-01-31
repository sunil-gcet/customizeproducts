<?php
/**
 * Copyright © 2015 Chilliapple. All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Model\ResourceModel;

/**
 * Customizecartdata resource
 */
class Customizecartdata extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('customizeproducts_customizecartdata', 'id');
    }

  
}