<?php
namespace Chilliapple\Customizeproducts\Controller\Designer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Productdesigner extends \Magento\Framework\App\Action\Action
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
		$this->_resultPageFactory = $resultPageFactory;
        $this->_dataHelper = $dataHelper;
        parent::__construct($context);
    }
	
	public function execute()
	{
		$data = $this->getRequest()->getParams();
		if ($data) {
			
			$resultPage = $this->_resultPageFactory->create();

			$block = $resultPage->getLayout()
					->createBlock('Magento\Framework\View\Element\Template')
					->setTemplate('Chilliapple_Customizeproducts::designer/productdesigner.phtml')->setPostdata($data)->toHtml();
			$this->getResponse()->setBody($block);		
		}
	}
}