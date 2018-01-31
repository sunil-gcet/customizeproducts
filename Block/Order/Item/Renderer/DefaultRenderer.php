<?php
namespace Chilliapple\Customizeproducts\Block\Order\Item\Renderer;
use Chilliapple\Customizeproducts\Model\Customizecartdata;

class DefaultRenderer extends \Magento\Sales\Block\Order\Item\Renderer\DefaultRenderer {
	
	protected $_customizeCartdataRsrce;
	protected $_storeManager;
	
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Stdlib\StringUtils $string,
		\Magento\Catalog\Model\Product\OptionFactory $productOptionFactory,
		Customizecartdata $customizeCartdataRes,
        array $data = []
    ) {
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
        parent::__construct($context, $string, $productOptionFactory);
    }
	
	public function getCustomizedcartdata() {
		
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
	
}