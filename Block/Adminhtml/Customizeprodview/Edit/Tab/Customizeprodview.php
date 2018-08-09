<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizeprodview\Edit\Tab;
class Customizeprodview extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
	\Chilliapple\Customizeproducts\Model\Config\Source\Productoptions $productArray,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
		$this->_pproductFactory = $productArray;
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
        $model = $this->_coreRegistry->registry('customizeproducts_customizeprodview');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Customize Product Views')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'title',
            'text',
            array(
                'name' => 'title',
                'label' => __('View Title'),
                'title' => __('View Title'),
                'required' => true,
            )
        );
		
		$productArray = $this->_pproductFactory->toOptionArray();
		$fieldset->addField(
			'product_id',
			'select',
			array(
				'label' => __('Select Parent Product'),
				'name' => 'product_id',
				'values' => $productArray,
				'required' => true,
			)
		);
		$fieldset->addField( 
			'view_image', 
			'image',
			array( 
				'name' => 'view_image', 
				'label' => __('Custom View Image'), 
				'title' => __('Custom View Image'),             
				'required' => true, 
			)
		)->setAfterElementHtml('
			<script>
				require([
					 "jquery",
				], function($){
					$(document).ready(function () {
						if($("#page_view_image").attr("value")){
							$("#page_view_image").removeClass("required-file");
						}else{
							$("#page_view_image").addClass("required-file");
						}
						$( "#page_view_image" ).attr( "accept", "image/x-png,image/gif,image/jpeg,image/jpg,image/png" );
					});
				  });
		   </script>
		');
		
		$fieldset->addField(
            'image_price',
            'text',
            array(
                'name' => 'image_price',
                'label' => __('Custom Image Price'),
                'title' => __('Custom Image Price'),
            )
        );
		
		$fieldset->addField(
            'text_price',
            'text',
            array(
                'name' => 'text_price',
                'label' => __('Custom Text Price'),
                'title' => __('Custom Text Price'),
            )
        );
		
		$fieldset->addField(
            'disable_image_upload', 'select', array(
            'name' => 'disable_image_upload',
            'label' => __('Disable Image Upload'),
            'title' => __('Disable Image Upload'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		
		$fieldset->addField(
            'disable_custom_text', 'select', array(
            'name' => 'disable_custom_text',
            'label' => __('Disable Custom Text'),
            'title' => __('Disable Custom Text'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		
		$fieldset->addField(
            'disable_facebook', 'select', array(
            'name' => 'disable_facebook',
            'label' => __('Disable Facebook'),
            'title' => __('Disable Facebook'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		
		$fieldset->addField(
            'disable_instagram', 'select', array(
            'name' => 'disable_instagram',
            'label' => __('Disable Instagram'),
            'title' => __('Disable Instagram'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		
		$fieldset->addField(
            'disable_designs', 'select', array(
            'name' => 'disable_designs',
            'label' => __('Disable Designs'),
            'title' => __('Disable Designs'),
            'values' => array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1')),
            )
        );
		/*{{CedAddFormField}}*/
        	
        if (!$model->getId()) {
            //$model->setData('status', $isElementDisabled ? '2' : '1');
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
        return __('Customize Product Views');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Customize Product Views');
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
