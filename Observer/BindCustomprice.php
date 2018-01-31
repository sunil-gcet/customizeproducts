<?php
namespace Chilliapple\Customizeproducts\Observer;
use Magento\Framework\Event\ObserverInterface;
use Chilliapple\Customizeproducts\Model\Customizecartdata;

class BindCustomprice implements ObserverInterface {
	
	protected $_customizeCartdataRsrce;
	
	protected $_checkoutSession;
	
	public function __construct(
		Customizecartdata $customizeCartdataRes,
		\Magento\Checkout\Model\Session $checkoutSession
	) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_checkoutSession = $checkoutSession;
	//Observer initialization code...
	//You can use dependency injection to get any class this observer may need.
	}
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$item = $observer->getEvent()->getData('quote_item');
		
		
		$item = ( $item->getParentItem() ? $item->getParentItem() : $item );
		
		
		
		
		$price = $item->getProduct()->getPrice();
		
		$price = $price + $this->getCustomizedcartdataprice(); //set your price here
		$item->setCustomPrice($price);
		$item->setOriginalCustomPrice($price);
		$item->getProduct()->setIsSuperMode(true);
		
		$this->updateCustomizationitem($item->getProduct()->getId(), $item->getQuote()->getId());
		
		return $this;
		//echo "<pre>";
		//print_r($observer->getEvent()->getData());
		//exit;
        //$item=$observer->getEvent()->getData('quote_item');
        //$product=$observer->getEvent()->getData('product');
		
        //$item = ( $item->getParentItem() ? $item->getParentItem() : $item );
        // Load the custom price
        //$price = $product->getPrice()+10; // 10 is custom price. It will increase in product price.		
        // Set the custom price
        //$item->setCustomPrice($price);
        //$item->setOriginalCustomPrice($price);
        // Enable super mode on the product.
        //$item->getProduct()->setIsSuperMode(true);
		//return $this;
    }
	
	public function getCustomizedcartdataprice() {
		
		$customizedIds = $this->_checkoutSession->getcustomizedData();
		return $this->_customizeCartdataRsrce->getCustomizedcartdataprice($customizedIds);
		
	}
	
	public function updateCustomizationitem($productId, $quoteId) {
				
		$this->_customizeCartdataRsrce->updateCustomizationitem($productId, $quoteId);
	}
}