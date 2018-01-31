<?php
namespace Chilliapple\Customizeproducts\Observer;
use Magento\Framework\Event\ObserverInterface;
use Chilliapple\Customizeproducts\Model\Customizecartdata;

class UpdateCustomrows implements ObserverInterface {
	
	protected $_customizeCartdataRsrce;
	
	protected $_checkoutSession;
	
	public function __construct(
		Customizecartdata $customizeCartdataRes,
		\Magento\Checkout\Model\Session $checkoutSession
	) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_checkoutSession = $checkoutSession;
	}
	
	public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $quote = $this->_checkoutSession->getQuote();
		$this->updateItembysession($product->getId(), $quote->getId());
	}
	
	public function updateItembysession($itemId, $quoteId) {
		$this->_customizeCartdataRsrce->updateCustomizationitem($itemId, $quoteId);
	}
}