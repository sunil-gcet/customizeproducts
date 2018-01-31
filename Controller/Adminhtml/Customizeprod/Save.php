<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customizeprod;
use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	public function execute()
    {
		
        $data = $this->getRequest()->getParams();
        if ($data) {
            $model = $this->_objectManager->create('Chilliapple\Customizeproducts\Model\Customizeprod');
			$id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
			$categorySelected = $data['category_id'];
			$data['category_id'] = implode(",", $data['category_id']);
			
			//echo "<pre>"; print_r($data); exit;
			
            $model->setData($data);
			
            try {
                $model->save();
				
				if(!isset($data['id'])) {
					$data['id'] = $model->getId();
				}
				$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
				$connection = $resource->getConnection();
				$tableName = $resource->getTableName('customizeproducts_prodtocat');
				
				//Delete Data from table
				$sql = "DELETE FROM " . $tableName." Where product_id = '".$data['id']."'";
				$connection->query($sql);
				
				//Insert Data into table
				foreach($categorySelected as $catId) {
					$sql = "INSERT INTO " . $tableName . " (product_id, category_id) Values ('".$data['id']."','".$catId."')";
					$connection->query($sql);
				}
                $this->messageManager->addSuccess(__('The customize product has been saved.'));
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
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}
