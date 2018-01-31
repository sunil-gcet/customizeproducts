<?php
/**
 * Copyright © 2015 Chilliapple. All rights reserved.
 */

namespace Chilliapple\Customizeproducts\Model;

use Magento\Framework\Exception\CustomizecartdataException;

/**
 * Customizecartdatatab Customizecartdata model
 */
class Customizecartdata extends \Magento\Framework\Model\AbstractModel
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
        $this->_init('Chilliapple\Customizeproducts\Model\ResourceModel\Customizecartdata');
    }
	
	public function getCustomizedcartdata($customizedIds = array(), $quoteId = '') {
		if(count($customizedIds)) {
			$collection = $this->getCollection();
			$dataSelect = array('in' => $customizedIds);
			$collection->addFieldToFilter('id', $dataSelect);
			if($quoteId) {
				$collection->addFieldToFilter('quote_id', $quoteId);
			}
			return $collection->getData();
		}
	}
	
	public function deleteCustomizedcartdata($productId, $quoteId) {
		
		if($productId) {
			
			//delete all for this quote for this product too
			$collection = $this->getCollection();
			$collection->addFieldToFilter('product_id', $productId);
			$collection->addFieldToFilter('quote_id', $quoteId);
			$collection->walk('delete');
			
			//delete all with current session for this product too
			$collection = $this->getCollection();
			$collection->addFieldToFilter('product_id', $productId);
			$collection->addFieldToFilter('session_id', session_id());
			$collection->walk('delete');
		}
		
	}
	
	public function updateCustomizationitem($productId, $quoteId) {

		
		if($productId != '' && $quoteId != '') {
			
			//add quote id for this product using session id
			$collection = $this->getCollection();
			$collection->addFieldToFilter('product_id', $productId);
			$collection->addFieldToFilter('session_id', session_id());
			$rowdata = $collection->getData();
			foreach($rowdata as $rdata) {
				$data = array(
					'id' => $rdata['id'],
					'quote_id' => $quoteId
				);
				$this->load($rdata['id'])->setData($data)->save();
			}
			
			//update session id using quote id for old entries for same quote
			$collectionOld = $this->getCollection();
			$collectionOld->addFieldToFilter('quote_id', $quoteId);
			$collectionOld->addFieldToFilter('session_id', array('neq' => session_id()));
			$rowdataOld = $collectionOld->getData();
			foreach($rowdataOld as $rdatao) {
				$datao = array(
					'id' => $rdatao['id'],
					'session_id' => session_id()
				);
				$this->load($rdatao['id'])->setData($datao)->save();
			}			
		}
		
	}
	
	public function updateItemorderidbysession($orderId, $quoteId) {
		if($orderId != '' && $quoteId != '') {
			
			$collection = $this->getCollection();
			$collection->addFieldToFilter('quote_id', $quoteId);
			$rowdata = $collection->getData();
			foreach($rowdata as $rdata) {
				$data = array(
					'id' => $rdata['id'],
					'order_increment_id' => $orderId
				);
				$this->load($rdata['id'])->setData($data)->save();
			}
		}
		
	}
	
	/*public function saveitemwithQuote($quoteId, $rowdata) {
		
		foreach($rowdata as $rdata) {
			print_r($rdata);
			$data = array(
				'quote_id' => $quoteId,
				);
			//$this->load($rdata['id'])->setData($data)->save();
			//$collection->setData($data)->walk('save');
		}
		exit;
	}
	*/
	
	
	public function getCustomizedcartdataprice($customizedIds = array()) {
		
		if(count($customizedIds)) {
			$collection = $this->getCollection();
			$dataSelect = array('in' => $customizedIds);
			$collection->addFieldToFilter('id', $dataSelect);
			
			$collection->getSelect()->reset(\Magento\Framework\DB\Select::COLUMNS)->columns('SUM(new_price) as custom_total')->group('product_id');
			//echo $collection->getSelect();
			//exit;
			foreach($collection as $cData) {
				if($cData->getcustomTotal()) {
					return $cData->getcustomTotal();
				} else {
					return 0;
				}
			}
		}
		return 0;
		
	}
	public function getOrderedproductData($orderincId, $productId) {
		
		if($orderincId != '' && $productId != '') {
			$collection = $this->getCollection();
			$collection->addFieldToFilter('order_increment_id', $orderincId);
			$collection->addFieldToFilter('product_id', $productId);
			//echo $collection->getSelect();
			return $collection->getData();
		}
	}
}