<?php
namespace Chilliapple\Customizeproducts\Observer;
use Magento\Framework\Event\ObserverInterface;
use Chilliapple\Customizeproducts\Model\Customizecartdata;

class RemoveCustomizedrows implements ObserverInterface {
	
	protected $_customizeCartdataRsrce;
	
	public function __construct(
		Customizecartdata $customizeCartdataRes
	) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
	}
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$item = $observer->getEvent()->getData('quote_item');
		$item = ( $item->getParentItem() ? $item->getParentItem() : $item );
		$quoteId = $item->getQuote()->getId();
		$this->deleteCustomizedcartdata($item->getProduct()->getId(), $quoteId);
		
    }	
	public function deleteCustomizedcartdata($productId, $quoteId) {
		
		$this->_customizeCartdataRsrce->deleteCustomizedcartdata($productId, $quoteId);
		
	}
}