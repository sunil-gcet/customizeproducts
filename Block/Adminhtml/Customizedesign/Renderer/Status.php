<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizedesign\Renderer;

class Status extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
	public function render(\Magento\Framework\DataObject $row)
    {
		// Get default value:
        $value = parent::_getValue($row);
		
		if($value == '1') {
			return "Yes";
		} else {
			return "No";
		}
    }
}