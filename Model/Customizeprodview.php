<?php
/**
 * Copyright © 2015 Chilliapple. All rights reserved.
 */

namespace Chilliapple\Customizeproducts\Model;

use Magento\Framework\Exception\CustomizeprodviewException;

/**
 * Customizeprodviewtab customizeprodview model
 */
class Customizeprodview extends \Magento\Framework\Model\AbstractModel
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
        $this->_init('Chilliapple\Customizeproducts\Model\ResourceModel\Customizeprodview');
    }
	
	public function addView($id_customizeproducts, $title, $elements = '', $thumbnail = '', $order = null) {
		
		if ($order === null) {
			$order = $this->getProductHtml($id_customizeproducts)->count();
        }
		$data['title'] = $title;
		$data['product_id'] = $id_customizeproducts;
		$data['view_image'] = $thumbnail;
		$data['elements'] = $elements;
		$data['view_order'] = $order;
		
		$this->setData($data);

        $this->save();
		
		return $this->getId();
		
	}

    public function getProductHtml($productId)
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter(
            'product_id',
            (int)$productId
        );
        return $collection;
    }
}