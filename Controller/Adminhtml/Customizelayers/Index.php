<?php
/**
 *
 * Copyright © 2015 Chilliapplecommerce. All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customizelayers;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Backend\App\Action
{

	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Check the permission to run it
     *
     * @return bool
     */
   /*  protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Cms::page');
    } */

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
		$data = $this->getRequest()->getParams();
		
        if ($data) {
			
			if(isset($data['element_types'])) {
			
				$model = $this->_objectManager->create('Chilliapple\Customizeproducts\Model\Customizeprodview');
				
				$elements = array();
				for ($i=0; $i < sizeof($data['element_types']); $i++) {

					$element = array();

					$element['type'] = $data['element_types'][$i];
					$element['title'] = $data['element_titles'][$i];
					$element['source'] = $data['element_sources'][$i];

					$parameters = array();
					parse_str($data['element_parameters'][$i], $parameters);

					if (is_array($parameters)) {
						foreach ($parameters as $key => $value) {
							if ($value == '') {
								$parameters[$key] = null;
							} else {
								$parameters[$key] = preg_replace('/\s+/', '', $value);
							}
						}
					}

					$element['parameters'] = $parameters;

					array_push($elements, $element);

				}
			
				$dataDb['elements'] = serialize($elements);
				
				$id = $data['view_id'];
				$dataDb['id'] = $id;
				if ($id) {
					$model->load($id);
				}
				$model->setData($dataDb);
			
				try {
					$model->save();
					$this->messageManager->addSuccess(__('The Product view has been Saved.'));
					$this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
					if ($this->getRequest()->getParam('back')) {
						$this->_redirect('*/*/');
						return;
					}
					$this->_redirect('*/*/');
					return;
				} catch (\Magento\Framework\Model\Exception $e) {
					$this->messageManager->addError($e->getMessage());
				} catch (\RuntimeException $e) {
					$this->messageManager->addError($e->getMessage());
				} catch (\Exception $e) {
					$this->messageManager->addException($e, __('Something went wrong while saving the view.'));
				}
				$this->_getSession()->setFormData($data);
				$this->_redirect('*/*/');
				return;
			}
		}
		//$this->_redirect('*/*/');
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
