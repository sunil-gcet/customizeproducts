<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml;
class Customizeprod extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_customizeprod';/*block grid.php directory*/
        $this->_blockGroup = 'Chilliapple_Customizeproducts';
        $this->_headerText = __('Customize Products');
        $this->_addButtonLabel = __('Add New Product'); 
        parent::_construct();
		
    }
}