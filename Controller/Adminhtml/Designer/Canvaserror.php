<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Designer;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Canvaserror extends \Magento\Backend\App\Action
{
	
	/**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @param Context $context
     * @param \Chilliapple\Customizeproducts\Helper\Data $dataHelper
     */
    public function __construct(Context $context, \Chilliapple\Customizeproducts\Helper\Data $dataHelper, PageFactory $resultPageFactory)
    {
        $this->_dataHelper = $dataHelper;
		$this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
	
	public function execute()
	{
		$data = $this->getRequest()->getParams();
		$resultPage = $this->_resultPageFactory->create();
 
        $block = $resultPage->getLayout()
                ->createBlock('Magento\Framework\View\Element\Template')
                ->setTemplate('Chilliapple_Customizeproducts::designer/canvaserror.phtml')->setPostdata($data)->toHtml();
        $this->getResponse()->setBody($block);
	}
}