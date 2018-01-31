<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customizeprod;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
		
		 $ids = $this->getRequest()->getParam('id');
		if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select product(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get('Chilliapple\Customizeproducts\Model\Customizeprod')->load($id);
					$row->delete();
					
					$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
					$connection = $resource->getConnection();
					$tableName = $resource->getTableName('customizeproducts_prodtocat');
					
					//Delete Data from table
					$sql = "DELETE FROM " . $tableName." Where product_id = '".$id."'";
					$connection->query($sql);
					
				}
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($ids))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
		 $this->_redirect('*/*/');
    }
}
