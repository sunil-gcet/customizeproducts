<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Chilliapple\Customizeproducts\Block\Order\Email\Items\Order;

use Magento\Sales\Model\Order\Item as OrderItem;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
/**
 * Sales Order Email items default renderer
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class DefaultOrder extends \Magento\Sales\Block\Order\Email\Items\Order\DefaultOrder
{
	protected $_customizeCartdataRsrce;
	protected $_storeManager;
	
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		Customizecartdata $customizeCartdataRes,
		array $data = []
	) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		parent::__construct($context, $data);
	}
		
	public function getCustomizedcartdata() {
		
		//echo get_class($this->_customizeCartdataRsrce);
		//exit;
		
		$productId = $this->getItem()->getProduct()->getId();		
		$orderincId = $this->getOrder()->getIncrementId();
		return $this->_customizeCartdataRsrce->getOrderedproductData($orderincId, $productId);
		
	}
	
	public function getcimageUrl($filename, $type='small') {
		if($type == 'small') {
			return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."customizeproducts/productimages/".$filename."_small.png";
		}
		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."customizeproducts/productimages/".$filename.".png";
	}
}