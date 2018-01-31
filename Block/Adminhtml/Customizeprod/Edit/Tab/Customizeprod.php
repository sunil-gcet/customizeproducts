<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizeprod\Edit\Tab;
class Customizeprod extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
	protected $_pcategoryFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
	 * @param \Chilliapple\Customizeproducts\Model\Config\Source\Categoryoptions $categoryArray
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
		\Chilliapple\Customizeproducts\Model\Config\Source\Categoryoptions $categoryArray,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
		$this->_pcategoryFactory = $categoryArray;
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
        $model = $this->_coreRegistry->registry('customizeproducts_customizeprod');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Customize Product')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'title',
            'text',
            array(
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            )
        );
		$categoryArray = $this->_pcategoryFactory->toOptionArray();
		$fieldset->addField(
			'category_id',
			'multiselect',
			array(
				'label' => __('Select Categories'),
				'name' => 'category_id[]',
				'values' => $categoryArray
			)
		);
		$fieldset->addField(
            'customize_product_width',
            'text',
            array(
                'name' => 'customize_product_width',
                'label' => __('Customize Product Width'),
                'title' => __('Customize Product Width'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'customize_product_height',
            'text',
            array(
                'name' => 'customize_product_height',
                'label' => __('Customize Product Height'),
                'title' => __('Customize Product Height'),
                /*'required' => true,*/
            )
        );
		/*$fieldset->addField(
            'status', 'select', array(
            'name' => 'status',
            'label' => __('Status'),
            'title' => __('Status'),
            'values' => array(0 => array('label' => __('Enable'), 'value' => '0'), 1 => array('label' => __('Disable'), 'value' => '1')),
            'required' => true,
            )
        );*/
		/*{{CedAddFormField}}*/
        
        /*if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '1' : '0');
        }*/
		
		//$data['category_id'] = isset($data['category_id']) ? explode(',', $data['category_id']) : array();
		///echo get_class($model);
		//print_r($model->getData()); exit;
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
        return __('Customize Product');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Customize Product');
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
