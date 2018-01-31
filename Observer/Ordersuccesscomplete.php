<?php
namespace Chilliapple\Customizeproducts\Observer;
use Magento\Framework\Event\ObserverInterface;
use Chilliapple\Customizeproducts\Model\Customizecartdata;

class Ordersuccesscomplete implements ObserverInterface {
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
		$this->_checkoutSession->setcustomizedData(array());
	}
	
}