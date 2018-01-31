<?php
namespace Chilliapple\Customizeproducts\Model\Total;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
class Customfee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
   /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null;
	
	protected $_customizeCartdataRsrce;
	
	protected $_checkoutSession;
 
    public function __construct(
		\Magento\Quote\Model\QuoteValidator $quoteValidator,
		Customizecartdata $customizeCartdataRes,
		\Magento\Checkout\Model\Session $checkoutSession
	) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
        $this->quoteValidator = $quoteValidator;
		$this->_checkoutSession = $checkoutSession;
    }
	
	public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
 
 
        $exist_amount = 0; //$quote->getCustomfee();
        $customfee = $this->getCustomizedcartdataprice(); //enter amount which you want to set
        $balance = $customfee - $exist_amount;//final amount
 
        $total->setTotalAmount('customfee', $balance);
        $total->setBaseTotalAmount('customfee', $balance);
 
        $total->setCustomfee($balance);
        $total->setBaseCustomfee($balance);
		
		$quote->setCustomfee($balance);
        $quote->setBaseCustomfee($balance);
 
        $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);
		
		//echo "<br>---".$quote->getId();
		//print_r($quote->getData());
		//exit;
        return $this;
    } 
 
    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code' => 'customfee',
            'title' => 'Customization Fee',
            'value' => $this->getCustomizedcartdataprice()
        ];
    }
 
    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Customization Fee');
    }
	public function getCustomizedcartdataprice() {
		
		$customizedIds = $this->_checkoutSession->getcustomizedData();
		return $this->_customizeCartdataRsrce->getCustomizedcartdataprice($customizedIds);
		
	}
}