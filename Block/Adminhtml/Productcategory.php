<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml;
class Productcategory extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_productcategory';/*block grid.php directory*/
        $this->_blockGroup = 'Chilliapple_Customizeproducts';
        $this->_headerText = __('Product Categories');
        $this->_addButtonLabel = __('Add New Category'); 
        parent::_construct();
		
    }
}