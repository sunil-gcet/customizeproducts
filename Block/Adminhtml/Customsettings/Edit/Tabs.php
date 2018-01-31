<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customsettings\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_customsettings_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Settings'));
		
		$this->setId('checkmodule_customsettings_tabs2');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Default Element Options'));
    }
}