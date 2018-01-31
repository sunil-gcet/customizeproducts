<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customsettings\Edit\Tab;
class Customsettings extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
		\Chilliapple\Customizeproducts\Helper\Data $helperData,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        $this->_helperData = $helperData;
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
        $model = $this->_coreRegistry->registry('customizeproducts_customsettings');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Layout & Skin')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'stage_width',
            'text',
            array(
                'name' => 'stage_width',
                'label' => __('Product Designer Width'),
                'title' => __('Product Designer Width'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'stage_height',
            'text',
            array(
                'name' => 'stage_height',
                'label' => __('Product Designer Height'),
                'title' => __('Product Designer Height'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'frame_shadow', 'select', array(
            'name' => 'frame_shadow',
            'label' => __('Product Designer Frame Shadow'),
            'title' => __('Product Designer Frame Shadow'),
            'values' => $this->_helperData->getFrameShadows(),
            )
        );
		$fieldset->addField(
            'dialog_box_positioning', 'select', array(
            'name' => 'dialog_box_positioning',
            'label' => __('Dialog Box Positioning'),
            'title' => __('Dialog Box Positioning'),
            'values' => $this->_helperData->getDialogBoxPositionings(),
            )
        );
		$fieldset->addField(
            'view_selection_position', 'select', array(
            'name' => 'view_selection_position',
            'label' => __('View Selection Positioning'),
            'title' => __('View Selection Positioning'),
            'values' => $this->_helperData->getViewSelectionPosititionsOptions(),
            )
        );
		$fieldset->addField(
            'Top',
            'text',
            array(
                'name' => 'Top',
                'label' => __('Product Designer Margin Top'),
                'title' => __('Product Designer Margin Top'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'Right',
            'text',
            array(
                'name' => 'Right',
                'label' => __('Product Designer Margin Right'),
                'title' => __('Product Designer Margin Right'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'Bottom',
            'text',
            array(
                'name' => 'Bottom',
                'label' => __('Product Designer Margin Bottom'),
                'title' => __('Product Designer Margin Bottom'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'Left',
            'text',
            array(
                'name' => 'Left',
                'label' => __('Product Designer Margin Left'),
                'title' => __('Product Designer Margin Left'),
                /*'required' => true,*/
            )
        );
		
		$fieldset->addField(
            'display_customizable', 'select', array(
            'name' => 'display_customizable',
            'label' => __('Display product is customizable'),
            'title' => __('Display product is customizable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		
		
		$fieldset2 = $form->addFieldset('base_fieldset2', array('legend' => __('Colors')));
		
		$fieldset2->addField(
            'designer_primary_color',
            'text',
            array(
                'name' => 'designer_primary_color',
                'label' => __('Designer Primary Color'),
                'title' => __('Designer Primary Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
				//'frontend_model' => 'Chilliapple\Customizeproducts\Block\ColorPicker',
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'designer_secondary_color',
            'text',
            array(
                'name' => 'designer_secondary_color',
                'label' => __('Designer Secondary Color'),
                'title' => __('Designer Secondary Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'designer_primary_text_color',
            'text',
            array(
                'name' => 'designer_primary_text_color',
                'label' => __('Designer Text Primary Color'),
                'title' => __('Designer Text Primary Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'designer_secondary_text_color',
            'text',
            array(
                'name' => 'designer_secondary_text_color',
                'label' => __('Designer Text Secondary Color'),
                'title' => __('Designer Text Secondary Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'selected_color',
            'text',
            array(
                'name' => 'selected_color',
                'label' => __('Element Selected Color'),
                'title' => __('Element Selected Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'bounding_box_color',
            'text',
            array(
                'name' => 'bounding_box_color',
                'label' => __('Bounding Box Color'),
                'title' => __('Bounding Box Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'out_of_boundary_color',
            'text',
            array(
                'name' => 'out_of_boundary_color',
                'label' => __('Out of Bounding Box Color'),
                'title' => __('Out of Bounding Box Color'),
				'class'  => 'jscolor {hash:true,refine:false}',
                /*'required' => true,*/
            )
        );
		
		$fieldset3 = $form->addFieldset('base_fieldset3', array('legend' => __('User Interface')));
		
		$fieldset3->addField(
            'upload_designs', 'select', array(
            'name' => 'upload_designs',
            'label' => __('Custom Image Upload'),
            'title' => __('Custom Image Upload'),
            'note' => __('Let customers upload their own images to products?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'facebook_tab', 'select', array(
            'name' => 'facebook_tab',
            'label' => __('Facebook Upload'),
            'title' => __('Facebook Upload'),
			'note' => __('Let customers upload image from facebook?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'instagram_tab', 'select', array(
            'name' => 'instagram_tab',
            'label' => __('Instagram Upload'),
            'title' => __('Instagram Upload'),
			'note' => __('Let customers upload image from instagram?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts', 'select', array(
            'name' => 'custom_texts',
            'label' => __('Custom Text'),
            'title' => __('Custom Text'),
			'note' => __('Let customers add their own text elements to products?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'download_product_image', 'select', array(
            'name' => 'download_product_image',
            'label' => __('Download Product Image'),
            'title' => __('Download Product Image'),
			'note' => __('Let customers download a product image?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'pdf_button', 'select', array(
            'name' => 'pdf_button',
            'label' => __('Save as PDF'),
            'title' => __('Save as PDF'),
			'note' => __('Let customers save the product as PDF?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'print', 'select', array(
            'name' => 'print',
            'label' => __('Print'),
            'title' => __('Print'),
			'note' => __('Let customers print the product?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'allow_product_saving', 'select', array(
            'name' => 'allow_product_saving',
            'label' => __('Allow Product Saving'),
            'title' => __('Allow Product Saving'),
			'note' => __('Let customers save their customized products?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'tooltips', 'select', array(
            'name' => 'tooltips',
            'label' => __('Tooltips'),
            'title' => __('Tooltips'),
			'note' => __('Use tooltips in the product designer?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		
		$fieldset4 = $form->addFieldset('base_fieldset4', array('legend' => __('Miscellaneous')));
		
		$fieldset4->addField(
            'max_image_size',
            'text',
            array(
                'name' => 'max_image_size',
                'label' => __('Maximum Image Size (MB)'),
                'title' => __('Maximum Image Size (MB)'),
				'note' => __('The maximum image size in Megabytes, when using the PHP uploader.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'min_dpi',
            'text',
            array(
                'name' => 'min_dpi',
                'label' => __('Minimum Allowed DPI'),
                'title' => __('Minimum Allowed DPI'),
				'note' => __('The minimum allowed DPI, when using the PHP uploader.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'facebook_app_id',
            'text',
            array(
                'name' => 'facebook_app_id',
                'label' => __('Facebook App-ID'),
                'title' => __('Facebook App-ID'),
				'note' => __('To allow users to add photos from facebook, you have to enter a Facebook App-Id.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'instagram_client_id',
            'text',
            array(
                'name' => 'instagram_client_id',
                'label' => __('Instagram Client ID'),
                'title' => __('Instagram Client ID'),
				'note' => __('To allow users to add photos from instagram, you have to enter a Instagram Client ID.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'google_font_client_id',
            'text',
            array(
                'name' => 'google_font_client_id',
                'label' => __('Google Api key'),
                'title' => __('Google Api key'),
				'note' => __('To fetch all the fonts from google.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'zoom_step',
            'text',
            array(
                'name' => 'zoom_step',
                'label' => __('Zoom Factor'),
                'title' => __('Zoom Factor'),
				'note' => __('The step for zooming in and out.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'max_zoom',
            'text',
            array(
                'name' => 'max_zoom',
                'label' => __('Maximum Zoom'),
                'title' => __('Maximum Zoom'),
				'note' => __('The maximum zoom when zooming in. Set it to "1" to disable the zoom feature.'),
                /*'required' => true,*/
            )
        );
		$fieldset4->addField(
            'padding_controls',
            'text',
            array(
                'name' => 'padding_controls',
                'label' => __('Padding Controls'),
                'title' => __('Padding Controls'),
				'note' => __('The padding of the controls when an element is selected in the product stage.'),
                /*'required' => true,*/
            )
        );
		
		$fieldset4->addField(
            'replace_initial_elements', 'select', array(
            'name' => 'replace_initial_elements',
            'label' => __('Replace Initial Elements'),
            'title' => __('Replace Initial Elements'),
			'note' => __('When a product designer contains multiple Customize Products and the customer adds custom elements to it and chooses another Customize Product, only the initial elements will be replaced.'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		
		$fieldset4->addField(
            'open_in_lightbox', 'select', array(
            'name' => 'open_in_lightbox',
            'label' => __('Open in lightbox'),
            'title' => __('Open in lightbox'),
            'values' => $this->_helperData->getStatusOptions(),
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
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('General');
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
