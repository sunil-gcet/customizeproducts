<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Order\View\Items\Renderer;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
/**
 * Adminhtml sales order item renderer
 */
class DefaultRenderer extends \Magento\Sales\Block\Adminhtml\Order\View\Items\Renderer\DefaultRenderer
{
	protected $_customizeCartdataRsrce;
	protected $_storeManager;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\Registry $registry,
        \Magento\GiftMessage\Helper\Message $messageHelper,
        \Magento\Checkout\Helper\Data $checkoutHelper,
		Customizecartdata $customizeCartdataRes,
        array $data = []
    ) {
        $this->_checkoutHelper = $checkoutHelper;
        $this->_messageHelper = $messageHelper;
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		
        parent::__construct($context, $stockRegistry, $stockConfiguration, $registry, $messageHelper, $checkoutHelper, $data);
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
	public function setTemplate($template)
	{
		return parent::setTemplate('Chilliapple_Customizeproducts::order/view/items/renderer/default.phtml');
	}
}
