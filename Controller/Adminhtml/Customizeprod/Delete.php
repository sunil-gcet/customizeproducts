<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customizeprod;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
		$id = $this->getRequest()->getParam('id');
		try {
				$banner = $this->_objectManager->get('Chilliapple\Customizeproducts\Model\Customizeprod')->load($id);
				$banner->delete();
				
				$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
				$connection = $resource->getConnection();
				$tableName = $resource->getTableName('customizeproducts_prodtocat');
				
				//Delete Data from table
				$sql = "DELETE FROM " . $tableName." Where product_id = '".$id."'";
				$connection->query($sql);
				
                $this->messageManager->addSuccess(
                    __('Delete successfully !')
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
	    $this->_redirect('*/*/');
    }
}
