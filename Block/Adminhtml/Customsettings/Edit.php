<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customsettings;

/**
 * CMS block edit form container
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
		$this->_objectId = 'id';
        $this->_blockGroup = 'Chilliapple_Customizeproducts';
        $this->_controller = 'adminhtml_customsettings';

        parent::_construct();
		
		$this->buttonList->remove('back');
		$this->buttonList->remove('delete');
		$this->buttonList->remove('save');
		
        $this->buttonList->add(
            'saveandcontinue',
            array(
                'label' => __('Save Settings'),
                'class' => 'save',
                'data_attribute' => array(
                    'mage-init' => array('button' => array('event' => 'saveAndContinueEdit', 'target' => '#edit_form'))
                )
            ),
            -100
        );

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'hello_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'hello_content');
                }
            }
        ";
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('checkmodule_checkmodel')->getId()) {
            return __("Edit Settings '%1'", $this->escapeHtml($this->_coreRegistry->registry('checkmodule_checkmodel')->getTitle()));
        } else {
            return __('New Settings');
        }
    }
}
