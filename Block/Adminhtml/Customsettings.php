<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml;
class Customsettings extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_customsettings';/*block grid.php directory*/
        $this->_blockGroup = 'Chilliapple_Customizeproducts';
        $this->_headerText = __('Settings');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}