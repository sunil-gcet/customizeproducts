<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizedesign\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{	
	public function render(\Magento\Framework\DataObject $row)
    {
		// Get default value:
        $value = parent::_getValue($row);
		
		if($value != '') {
			//$om = \Magento\Framework\App\ObjectManager::getInstance();
			//$storeManager = $om->get('Magento\Store\Model\StoreManagerInterface');
			//$filePath = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $value;
			
			return "<img src='".$value."' width='60' height='60' class='design_image'>";
			
		} else {
			return "No image";
		}
    }
}