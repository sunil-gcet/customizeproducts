<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customsettings\Edit\Tab;
class Customdefault extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Image Options')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'designs_parameter_x',
            'text',
            array(
                'name' => 'designs_parameter_x',
                'label' => __('X-Position'),
                'title' => __('X-Position'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_y',
            'text',
            array(
                'name' => 'designs_parameter_y',
                'label' => __('Y-Position'),
                'title' => __('Y-Position'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_z',
            'text',
            array(
                'name' => 'designs_parameter_z',
                'label' => __('Z-Position'),
                'title' => __('Z-Position'),
				'note' => __('-1 means that the element will be added at the top. Any value higher than that will add the element to that z-position.'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_colors',
            'text',
            array(
                'name' => 'designs_parameter_colors',
                'label' => __('Colors'),
                'title' => __('Colors'),
				'note' => __('Enter hex color(s) separated by comma.'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_price',
            'text',
            array(
                'name' => 'designs_parameter_price',
                'label' => __('Price'),
                'title' => __('Price'),
				'note' => __('Enter the additional price for a design element. Use always a dot as decimal separator!'),
                /*'required' => true,*/
            )
        );
		
		$fieldset->addField(
            'designs_parameter_autoCenter', 'select', array(
            'name' => 'designs_parameter_autoCenter',
            'label' => __('Auto-Center'),
            'title' => __('Auto-Center'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_draggable', 'select', array(
            'name' => 'designs_parameter_draggable',
            'label' => __('Draggable'),
            'title' => __('Draggable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_rotatable', 'select', array(
            'name' => 'designs_parameter_rotatable',
            'label' => __('Rotatable'),
            'title' => __('Rotatable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_resizable', 'select', array(
            'name' => 'designs_parameter_resizable',
            'label' => __('Resizable'),
            'title' => __('Resizable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_zChangeable', 'select', array(
            'name' => 'designs_parameter_zChangeable',
            'label' => __('Z-Changeable'),
            'title' => __('Z-Changeable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		
		$fieldset->addField(
            'designs_parameter_replace',
            'text',
            array(
                'name' => 'designs_parameter_replace',
                'label' => __('Replace'),
                'title' => __('Replace'),
				'note' => __('Elements with the same replace name will replace each other.'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'fpd_designs_parameter_autoSelect', 'select', array(
            'name' => 'fpd_designs_parameter_autoSelect',
            'label' => __('Auto-Select'),
            'title' => __('Auto-Select'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_topped', 'select', array(
            'name' => 'designs_parameter_topped',
            'label' => __('Stay On Top'),
            'title' => __('Stay On Top'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_bounding_box_control', 'select', array(
            'name' => 'designs_parameter_bounding_box_control',
            'label' => __('Use another element as bounding box?'),
            'title' => __('Use another element as bounding box?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
            'designs_parameter_bounding_box_by_other',
            'text',
            array(
                'name' => 'designs_parameter_bounding_box_by_other',
                'label' => __('Bounding Box Target'),
                'title' => __('Bounding Box Target'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_bounding_box_x',
            'text',
            array(
                'name' => 'designs_parameter_bounding_box_x',
                'label' => __('Bounding Box X-Position'),
                'title' => __('Bounding Box X-Position'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_bounding_box_y',
            'text',
            array(
                'name' => 'designs_parameter_bounding_box_y',
                'label' => __('Bounding Box Y-Position'),
                'title' => __('Bounding Box Y-Position'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_bounding_box_width',
            'text',
            array(
                'name' => 'designs_parameter_bounding_box_width',
                'label' => __('Bounding Box Width'),
                'title' => __('Bounding Box Width'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_bounding_box_height',
            'text',
            array(
                'name' => 'designs_parameter_bounding_box_height',
                'label' => __('Bounding Box Height'),
                'title' => __('Bounding Box Height'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'designs_parameter_boundingBoxClipping', 'select', array(
            'name' => 'designs_parameter_boundingBoxClipping',
            'label' => __('Bounding Box Clipping'),
            'title' => __('Bounding Box Clipping'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset->addField(
			'designs_parameter_filters',
			'multiselect',
			array(
				'label' => __('Filters'),
				'name' => 'designs_parameter_filters[]',
				'values' => $this->_helperData->getFiltersOptions(),
			)
		);
		
		$fieldset2 = $form->addFieldset('base_fieldset2', array('legend' => __('Custom Image Options')));
		
		$fieldset2->addField(
            'uploaded_designs_parameter_minW',
            'text',
            array(
                'name' => 'uploaded_designs_parameter_minW',
                'label' => __('Minimum Width'),
                'title' => __('Minimum Width'),
				'note' => __('The minimum image width for uploaded designs from the customers.'),
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'uploaded_designs_parameter_minH',
            'text',
            array(
                'name' => 'uploaded_designs_parameter_minH',
                'label' => __('Minimum Height'),
                'title' => __('Minimum Height'),
				'note' => __('The minimum image height for uploaded designs from the customers.'),
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'uploaded_designs_parameter_maxW',
            'text',
            array(
                'name' => 'uploaded_designs_parameter_maxW',
                'label' => __('Maximum Width'),
                'title' => __('Maximum Width'),
				'note' => __('The maximum image width for uploaded designs from the customers.'),
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'uploaded_designs_parameter_maxH',
            'text',
            array(
                'name' => 'uploaded_designs_parameter_maxH',
                'label' => __('Maximum Height'),
                'title' => __('Maximum Height'),
				'note' => __('The maximum image height for uploaded designs from the customers.'),
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'uploaded_designs_parameter_resizeToW',
            'text',
            array(
                'name' => 'uploaded_designs_parameter_resizeToW',
                'label' => __('Resize To Width'),
                'title' => __('Resize To Width'),
				'note' => __('Resize the uploaded image to this width, when width is larger than height.'),
                /*'required' => true,*/
            )
        );
		$fieldset2->addField(
            'uploaded_designs_parameter_resizeToH',
            'text',
            array(
                'name' => 'uploaded_designs_parameter_resizeToH',
                'label' => __('Resize To Height'),
                'title' => __('Resize To Height'),
				'note' => __('Resize the uploaded image to this height, when height is larger than width.'),
                /*'required' => true,*/
            )
        );
		
		$fieldset3 = $form->addFieldset('base_fieldset3', array('legend' => __('Custom Text Options')));
		
		$fieldset3->addField(
            'custom_texts_parameter_x',
            'text',
            array(
                'name' => 'custom_texts_parameter_x',
                'label' => __('X-Position'),
                'title' => __('X-Position'),
				'note' => __('The x-position of the custom text element.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_y',
            'text',
            array(
                'name' => 'custom_texts_parameter_y',
                'label' => __('Y-Position'),
                'title' => __('Y-Position'),
				'note' => __('The y-position of the custom text element.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_z',
            'text',
            array(
                'name' => 'custom_texts_parameter_z',
                'label' => __('Z-Position'),
                'title' => __('Z-Position'),
				'note' => __('-1 means that the element will be added at the top. Any value higher than that will add the element to that z-position.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_colors',
            'text',
            array(
                'name' => 'custom_texts_parameter_colors',
                'label' => __('Colors'),
                'title' => __('Colors'),
				'note' => __('Enter hex color(s) separated by comma.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_price',
            'text',
            array(
                'name' => 'custom_texts_parameter_price',
                'label' => __('Price'),
                'title' => __('Price'),
				'note' => __('Enter the additional price for a text element. Always use a dot as decimal separator!'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_autoCenter', 'select', array(
            'name' => 'custom_texts_parameter_autoCenter',
            'label' => __('Auto-Center'),
            'title' => __('Auto-Center'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_draggable', 'select', array(
            'name' => 'custom_texts_parameter_draggable',
            'label' => __('Draggable'),
            'title' => __('Draggable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_rotatable', 'select', array(
            'name' => 'custom_texts_parameter_rotatable',
            'label' => __('Rotatable'),
            'title' => __('Rotatable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_resizable', 'select', array(
            'name' => 'custom_texts_parameter_resizable',
            'label' => __('Resizable'),
            'title' => __('Resizable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_zChangeable', 'select', array(
            'name' => 'custom_texts_parameter_zChangeable',
            'label' => __('Z-Changeable'),
            'title' => __('Z-Changeable'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_replace',
            'text',
            array(
                'name' => 'custom_texts_parameter_replace',
                'label' => __('Replace'),
                'title' => __('Replace'),
				'note' => __('Elements with the same replace name will replace each other.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_autoSelect', 'select', array(
            'name' => 'custom_texts_parameter_autoSelect',
            'label' => __('Auto-Select'),
            'title' => __('Auto-Select'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_topped', 'select', array(
            'name' => 'custom_texts_parameter_topped',
            'label' => __('Stay On Top'),
            'title' => __('Stay On Top'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_patternable', 'select', array(
            'name' => 'custom_texts_parameter_patternable',
            'label' => __('Patternable'),
            'title' => __('Patternable'),
			'note' => __('Let the customer choose a pattern?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_curvable', 'select', array(
            'name' => 'custom_texts_parameter_curvable',
            'label' => __('Curvable'),
            'title' => __('Curvable'),
			'note' => __('Let the customer make the text curved?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_curveSpacing',
            'text',
            array(
                'name' => 'custom_texts_parameter_curveSpacing',
                'label' => __('Curve Spacing'),
                'title' => __('Curve Spacing'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_curveRadius',
            'text',
            array(
                'name' => 'custom_texts_parameter_curveRadius',
                'label' => __('Curve Radius'),
                'title' => __('Curve Radius'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_curveReverse', 'select', array(
            'name' => 'custom_texts_parameter_curveReverse',
            'label' => __('Curve Reverse'),
            'title' => __('Curve Reverse'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_bounding_box_control', 'select', array(
            'name' => 'custom_texts_parameter_bounding_box_control',
            'label' => __('Use another element as bounding box?'),
            'title' => __('Use another element as bounding box?'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_bounding_box_by_other',
            'text',
            array(
                'name' => 'custom_texts_parameter_bounding_box_by_other',
                'label' => __('Bounding Box Target'),
                'title' => __('Bounding Box Target'),
				'note' => __('Enter the title of another element that should be used as bounding box for design elements.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_bounding_box_x',
            'text',
            array(
                'name' => 'custom_texts_parameter_bounding_box_x',
                'label' => __('Bounding Box X-Position'),
                'title' => __('Bounding Box X-Position'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_bounding_box_y',
            'text',
            array(
                'name' => 'custom_texts_parameter_bounding_box_y',
                'label' => __('Bounding Box Y-Position'),
                'title' => __('Bounding Box Y-Position'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_bounding_box_width',
            'text',
            array(
                'name' => 'custom_texts_parameter_bounding_box_width',
                'label' => __('Bounding Box Width'),
                'title' => __('Bounding Box Width'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_bounding_box_height',
            'text',
            array(
                'name' => 'custom_texts_parameter_bounding_box_height',
                'label' => __('Bounding Box Height'),
                'title' => __('Bounding Box Height'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_boundingBoxClipping', 'select', array(
            'name' => 'custom_texts_parameter_boundingBoxClipping',
            'label' => __('Bounding Box Clipping'),
            'title' => __('Bounding Box Clipping'),
            'values' => $this->_helperData->getStatusOptions(),
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_textSize',
            'text',
            array(
                'name' => 'custom_texts_parameter_textSize',
                'label' => __('Default Text Size'),
                'title' => __('Default Text Size'),
				'note' => __('The default text size for all text elements.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'font',
            'text',
            array(
                'name' => 'font',
                'label' => __('Default Font'),
                'title' => __('Default Font'),
				'note' => __('Enter the default font. If you leave it empty, the first font from the fonts dropdown will be used.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_maxLength',
            'text',
            array(
                'name' => 'custom_texts_parameter_maxLength',
                'label' => __('Maximum Characters'),
                'title' => __('Maximum Characters'),
				'note' => __('You can limit the number of characters. 0 means unlimited characters.'),
                /*'required' => true,*/
            )
        );
		$fieldset3->addField(
            'custom_texts_parameter_textAlign', 'select', array(
            'name' => 'custom_texts_parameter_textAlign',
            'label' => __('Alignment'),
            'title' => __('Alignment'),
            'values' => $this->_helperData->getAlignmentOptions(),
            )
        );
		
		$fieldset4 = $form->addFieldset('base_fieldset4', array('legend' => __('Common Options')));
		
		$fieldset4->addField(
            'common_parameter_originX', 'select', array(
            'name' => 'common_parameter_originX',
            'label' => __('Origin-X Point'),
            'title' => __('Origin-X Point'),
            'values' => $this->_helperData->getOriginOptions(),
            )
        );
		
		$fieldset4->addField(
            'common_parameter_originY', 'select', array(
            'name' => 'common_parameter_originY',
            'label' => __('Origin-Y Point'),
            'title' => __('Origin-Y Point'),
            'values' => $this->_helperData->getOriginOptions(),
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
        return __('Default Element Settings');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Default Element Settings');
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
