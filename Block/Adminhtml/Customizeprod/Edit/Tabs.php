<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizeprod\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_customizeprod_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Customize Products'));
    }
}