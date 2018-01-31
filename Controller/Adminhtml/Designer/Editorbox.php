<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Designer;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Editorbox extends \Magento\Backend\App\Action
{
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
		$this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
	
	public function execute()
	{
		$data = $this->getRequest()->getParams();
		if ($data) {

			$resultPage = $this->_resultPageFactory->create();
 
			$block = $resultPage->getLayout()
					->createBlock('Magento\Framework\View\Element\Template')
					->setTemplate('Chilliapple_Customizeproducts::designer/editorbox.phtml')->setPostdata($data)->toHtml();
			$this->getResponse()->setBody($block);		
		}
	}
}