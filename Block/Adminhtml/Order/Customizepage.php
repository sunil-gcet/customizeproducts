<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Order;

class Customizepage extends \Magento\Sales\Block\Adminhtml\Order\View
{
	public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Sales\Helper\Reorder $reorderHelper,
		\Chilliapple\Customizeproducts\Helper\Data $helperData,
		\Chilliapple\Customizeproducts\Helper\Ajaxfunctions $ajaxhelperData,
        array $data = []
    ) {
		$this->_helperData = $helperData;
		$this->_ajaxhelperData = $ajaxhelperData;
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
    }
	
	public function getenabledFonts() {
		$google_webfonts = $this->_helperData->getEnabledGoogleFonts();
		$max_fonts_per_href = 10;
		$href_wf = array();
		$href_wf_text = '';
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
}
