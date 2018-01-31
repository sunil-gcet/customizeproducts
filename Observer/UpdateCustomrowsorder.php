<?php
namespace Chilliapple\Customizeproducts\Observer;
use Magento\Framework\Event\ObserverInterface;
use Chilliapple\Customizeproducts\Model\Customizecartdata;

class UpdateCustomrowsorder implements ObserverInterface {
	
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
        $order = $observer->getOrder();
        $quote = $observer->getQuote();
		//echo "<br>--".$quote->getReservedOrderId();
		//echo "<br>--".$quote->getId();
		$this->updateItemorderidbysession($quote->getReservedOrderId(), $quote->getId());
	}
	
	public function updateItemorderidbysession($orderId, $quoteId) {
		//echo "<br>--".$orderId;
		//echo "<br>--".$quoteId;
		$this->_customizeCartdataRsrce->updateItemorderidbysession($orderId, $quoteId);
	}
}