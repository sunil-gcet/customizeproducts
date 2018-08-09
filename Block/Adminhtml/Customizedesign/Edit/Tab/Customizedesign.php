<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizedesign\Edit\Tab;
class Customizedesign extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
		/* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('customizeproducts_customizedesign');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Customize Design')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }
		
		$fieldset->addField( 
			'design_image', 
			'image',
			array( 
				'name' => 'design_image', 
				'label' => __('Design Image'), 
				'title' => __('Design Image'),             
				'required' => true, 
			)
		)->setAfterElementHtml('
			<script>
				require([
					 "jquery",
				], function($){
					$(document).ready(function () {
						if($("#page_design_image").attr("value")){
							$("#page_design_image").removeClass("required-file");
						}else{
							$("#page_design_image").addClass("required-file");
						}
						$( "#page_design_image" ).attr( "accept", "image/x-png,image/gif,image/jpeg,image/jpg,image/png" );
					});
				  });
		   </script>
		');
		
		$fieldset->addField(
            'enabled', 'select', array(
            'name' => 'enabled',
            'label' => __('Enable Options'),
            'title' => __('Enable Options'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		
		$fieldset->addField(
            'x',
            'text',
            array(
                'name' => 'x',
                'label' => __('X-Position'),
                'title' => __('X-Position'),
            )
        );
		
		$fieldset->addField(
            'y',
            'text',
            array(
                'name' => 'y',
                'label' => __('Y-Position'),
                'title' => __('Y-Position'),
            )
        );
		
		$fieldset->addField(
            'z',
            'text',
            array(
                'name' => 'z',
                'label' => __('Z-Position'),
                'title' => __('Z-Position'),
            )
        );
		
		$fieldset->addField(
            'scale',
            'text',
            array(
                'name' => 'scale',
                'label' => __('Scale'),
                'title' => __('Scale'),
            )
        );
		$fieldset->addField(
            'colors',
            'text',
            array(
                'name' => 'colors',
                'label' => __('Color(s)'),
                'title' => __('Color(s)'),
            )
        );
		$fieldset->addField(
            'price',
            'text',
            array(
                'name' => 'price',
                'label' => __('Price'),
                'title' => __('Price'),
            )
        );
		$fieldset->addField(
            'autoCenter', 'select', array(
            'name' => 'autoCenter',
            'label' => __('Auto Center'),
            'title' => __('Auto Center'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		$fieldset->addField(
            'draggable', 'select', array(
            'name' => 'draggable',
            'label' => __('Draggable'),
            'title' => __('Draggable'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		$fieldset->addField(
            'rotatable', 'select', array(
            'name' => 'rotatable',
            'label' => __('Rotatable'),
            'title' => __('Rotatable'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		$fieldset->addField(
            'resizable', 'select', array(
            'name' => 'resizable',
            'label' => __('Resizable'),
            'title' => __('Resizable'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		/*{{CedAddFormField}}*/
        
        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();   
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Customize Design');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Customize Design');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
