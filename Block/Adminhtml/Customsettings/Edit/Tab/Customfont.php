<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customsettings\Edit\Tab;
class Customfont extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Fonts Settings')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'common_fonts',
            'text',
            array(
                'name' => 'common_fonts',
                'label' => __('Common Fonts'),
                'title' => __('Common Fonts'),
                /*'required' => true,*/
				'note' => __('Enter here common fonts separated by comma, which are installed on all system by default, e.g. Arial.'),
            )
        );
		
		$fieldset->addField(
			'google_webfonts',
			'multiselect',
			array(
				'label' => __('Google Webfonts'),
				'name' => 'google_webfonts[]',
				'values' => $this->_helperData->getGoogleWebfonts(),
				'note' => __('Choose fonts from Google Webfonts. Using more than 3 fonts will cause your site to load more slowly.'),
			)
		);
		
		$fieldset->addField(
			'fonts_directory',
			'multiselect',
			array(
				'label' => __('Fonts Directory'),
				'name' => 'fonts_directory[]',
				'values' => $this->_helperData->getWoffFonts(),
				'note' => __('You can add your own fonts to the fonts directory of the plugin, these font files need to be .woff files.'),
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
        return __('Fonts');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Fonts');
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
