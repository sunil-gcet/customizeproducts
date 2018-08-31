<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Order;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
class Customizepage extends \Magento\Sales\Block\Adminhtml\Order\View
{
	public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Sales\Helper\Reorder $reorderHelper,
		\Chilliapple\Customizeproducts\Helper\Data $helperData,
		\Chilliapple\Customizeproducts\Helper\Ajaxfunctions $ajaxhelperData,
		Customizecartdata $customizeCartdataRes,
        array $data = []
    ) {
		$this->_helperData = $helperData;
		$this->_ajaxhelperData = $ajaxhelperData;
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
    }
	
	public function getenabledFonts() {
		$google_webfonts = $this->_helperData->getEnabledGoogleFonts();
		$max_fonts_per_href = 10;
		$href_wf = array();		$href_wf_text = '';
		if (!empty($google_webfonts)) {
			for ($i=0; $i < sizeof($google_webfonts); $i++) {
				array_push($href_wf, $google_webfonts[$i]);
				if (($i % $max_fonts_per_href) == $max_fonts_per_href-1 || $i == sizeof($google_webfonts)-1) {
					$href_wf_text = implode("|", $href_wf);
				}
			}
		}
		return $href_wf_text;
	}
	
	public function ifCustomizeProductExists() {
		$havecustomizedProducts = false;
		$items = $this->getOrder()->getAllItems();
		foreach ($items as $item) {
			if($this->getProductCustomization($item->getProductId())) {
				$havecustomizedProducts = true;
			}
		}
		return $havecustomizedProducts;
	}
	
	private function getProductCustomization($productId) {
		$orderincId = $this->getOrder()->getIncrementId();
		$productData = $this->_customizeCartdataRsrce->getOrderedproductData($orderincId, $productId);
		if(count($productData) > 0) {
			return true;
		}
		return false;
	}
}
