<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml;
class Customizeprodview extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_customizeprodview';/*block grid.php directory*/
        $this->_blockGroup = 'Chilliapple_Customizeproducts';
        $this->_headerText = __('Customize Product Views');
        $this->_addButtonLabel = __('Add New View'); 
        parent::_construct();
		
    }
}