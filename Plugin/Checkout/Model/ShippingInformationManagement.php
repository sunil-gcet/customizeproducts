<?php
namespace Chilliapple\Customizeproducts\Plugin\Checkout\Model;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
class ShippingInformationManagement
{
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;
	
	protected $_customizeCartdataRsrce;
	
	protected $_checkoutSession;
    /**
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     */
    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
		\Magento\Checkout\Model\Session $checkoutSession,
		Customizecartdata $customizeCartdataRes
    )
    {
        $this->quoteRepository = $quoteRepository;
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_checkoutSession = $checkoutSession;
    }
    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    )
    {
        $customFee = $addressInformation->getExtensionAttributes()->getCustomfee();
        $quote = $this->quoteRepository->getActive($cartId);
        if ($customFee) {
            $customfee = $this->getCustomizedcartdataprice();
            //$quote->setCustomfee($customfee);
        } else {
            //$quote->setCustomfee(NULL);
        }
    }
	
	public function getCustomizedcartdataprice() {
		
		$customizedIds = $this->_checkoutSession->getcustomizedData();
		return $this->_customizeCartdataRsrce->getCustomizedcartdataprice($customizedIds);
		
	}
}