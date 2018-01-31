<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml;
class Customizedesign extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_customizedesign';/*block grid.php directory*/
        $this->_blockGroup = 'Chilliapple_Customizeproducts';
        $this->_headerText = __('Customize Designs');
        $this->_addButtonLabel = __('Add New Design'); 
        parent::_construct();
		
    }
}