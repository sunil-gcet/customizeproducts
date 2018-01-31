<?php
namespace Chilliapple\Customizeproducts\Controller\Designer;

use Magento\Framework\App\Action\Context;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
use Magento\Framework\Controller\ResultFactory;

class Deletecustomization extends \Magento\Framework\App\Action\Action
{
	protected $_customizeCartdataRsrce;
	/**
     * @param Context $context
     * @param \Chilliapple\Customizeproducts\Helper\Data $dataHelper
     */
    public function __construct(Context $context, Customizecartdata $customizeCartdataRes)
    {
        $this->_customizeCartdataRsrce = $customizeCartdataRes;
        parent::__construct($context);
    }
	
	public function execute()
	{
		$data = $this->getRequest()->getParams();
		$deleteId = $data['icc'];
		if ($deleteId) {
			try {
				$this->_customizeCartdataRsrce->load($deleteId)->delete();
				//$message = __('You have successfully deleted the customization.');
				//$this->messageManager->addSuccessMessage($message);
				$return = array();
				$return['hasError'] = false;
				$return['success'] = __('You have successfully deleted the customization.');
			} catch (\Magento\Framework\Model\Exception $e) {
				//$this->messageManager->addError(__('We can\'t remove the customization item.'));
				$return = array();
				$return['hasError'] = true;
				$return['error'] = __('We can\'t remove the customization item.');
			}
			//$defaultUrl = $this->_objectManager->create('Magento\Framework\UrlInterface')->getUrl('*/*');
			//return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRedirectUrl($defaultUrl));
		} else {
			$return = array();
			$return['hasError'] = true;
			$return['error'] = __('We can\'t remove the customization item.');
		}
		//echo json_encode($return);
		//exit;
		//$this->_redirect('*/*/');
		$this->getResponse()->setBody(json_encode($return));
	}
}