<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizedesign\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_customizedesign_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Customize Designs'));
    }
}