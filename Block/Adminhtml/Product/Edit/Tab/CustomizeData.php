<?php

namespace Chilliapple\Customizeproducts\Block\Adminhtml\Product\Edit\Tab;

use Magento\Backend\Block\Widget;

/**
 * Class CustomizeData
 *
 * @package Chilliapple\Customizeproducts\Block\Adminhtml\Product\Edit\Tab
 */
class CustomizeData extends Widget
{
    /**
     * @var string
     */
    protected $_template = 'Chilliapple_Customizeproducts::catalog/product/edit/tab/customize-data.phtml';

    /**
     * @return Widget
     */
    protected function _prepareLayout()
    {
        $this->addChild(
            'add_button',
            'Magento\Backend\Block\Widget\Button',
            ['label' => __('Add New Description'), 'class' => 'add', 'id' => 'add_new_custom_description']
        );

        $this->addChild('customize_data_box', 'Chilliapple\Customizeproducts\Block\Adminhtml\Product\Edit\Tab\CustomizeData\Data');

        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }

    /**
     * @return string
     */
    public function getCustomizeDataBoxHtml()
    {
        return $this->getChildHtml('customize_data_box');
    }
}
