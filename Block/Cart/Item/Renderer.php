<?php
namespace Chilliapple\Customizeproducts\Block\Cart\Item;

use Chilliapple\Customizeproducts\Model\Customizecartdata;

use Magento\Checkout\Block\Cart\Item\Renderer\Actions;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Catalog\Pricing\Price\ConfiguredPriceInterface;

class Renderer extends \Magento\Checkout\Block\Cart\Item\Renderer {
	
	protected $_customizeCartdataRsrce;
	
	protected $_checkoutSession;
	
	protected $_storeManager;
	
	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Product\Configuration $productConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Module\Manager $moduleManager,
        InterpretationStrategyInterface $messageInterpretationStrategy,
		Customizecartdata $customizeCartdataRes,
        array $data = []
    ) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_checkoutSession = $checkoutSession;
        parent::__construct($context, $productConfig, $checkoutSession, $imageBuilder, $urlHelper, $messageManager, $priceCurrency, $moduleManager, $messageInterpretationStrategy, $data);
    }
		
	public function getCustomizedcartdata() {
		
		$customizedIds = $this->_checkoutSession->getcustomizedData();
		$quote = $this->_checkoutSession->getQuote();
		$quoteId = $quote->getId();
		return $this->_customizeCartdataRsrce->getCustomizedcartdata($customizedIds, $quoteId);
		
	}
	
	public function getcimageUrl($filename, $type='small') {
		if($type == 'small') {
			return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."customizeproducts/productimages/".$filename."_small.png";
		}
		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."customizeproducts/productimages/".$filename.".png";
	}
	
	public function setTemplate($template)
	{
	return parent::setTemplate('Chilliapple_Customizeproducts::cart/item/default.phtml');
	}
}