<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customsettings;
use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	public function execute() {		
        $data = $this->getRequest()->getParams();
        if ($data) {
            $model = $this->_objectManager->create('Chilliapple\Customizeproducts\Model\Customsettings');
			$id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
			if(!isset($data['stage_width']) || $data['stage_width'] <= 0) {
				$data['stage_width'] = '800';
			}
			if(!isset($data['stage_height']) || $data['stage_height'] <= 0) {
				$data['stage_height'] = '600';
			}
			if(isset($data['designs_parameter_filters']) && count($data['designs_parameter_filters'])) {
				$data['designs_parameter_filters'] = '"'.implode('", "', $data['designs_parameter_filters']).'"';
			}
			if(isset($data['google_webfonts']) && count($data['google_webfonts'])) {
				$data['google_webfonts'] = implode(",", $data['google_webfonts']);
			}
			if(isset($data['fonts_directory']) && count($data['fonts_directory'])) {
				$data['fonts_directory'] = implode(",", $data['fonts_directory']);
			}
            $model->setData($data);
			
            try {

                $model->save();
                $this->messageManager->addSuccess(__('The Settings Has been Saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
				
                $this->messageManager->addException($e, __('Something went wrong while saving the settings.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}
