<?php
namespace Chilliapple\Customizeproducts\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
class AddFeeToOrderObserver implements ObserverInterface
{
    /**
     * Set payment fee to order
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getEvent()->getData('quote');
		$CustomFeeFee = $quote->getCustomfee();
        $CustomFeeBaseFee = $quote->getBaseCustomfee();
        if (!$CustomFeeFee || !$CustomFeeBaseFee) {
            return $this;
        }
        //Set fee data to order
        $order = $observer->getEvent()->getData('order');
		//echo $order->getId(); exit;
        $order->setCustomfee($CustomFeeFee);
        $order->setBaseCustomfee($CustomFeeBaseFee);
		
        return $this;
    }
}