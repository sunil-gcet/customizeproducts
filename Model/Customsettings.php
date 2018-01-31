<?php
/**
 * Copyright © 2015 Chilliapple. All rights reserved.
 */

namespace Chilliapple\Customizeproducts\Model;

use Magento\Framework\Exception\CustomsettingsException;

/**
 * Customsettingstab customsettings model
 */
class Customsettings extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Chilliapple\Customizeproducts\Model\ResourceModel\Customsettings');
    }

   
}