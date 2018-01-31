<?php
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customizeprodview;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\StoreManagerInterface;
class Save extends \Magento\Backend\App\Action
{
	protected $_fileUploaderFactory;
	
	protected $_storeManager;
 
	public function __construct(
		\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
		StoreManagerInterface $storeManager,
		\Magento\Backend\App\Action\Context $context
		  
	) {
	 
		$this->_fileUploaderFactory = $fileUploaderFactory;
		$this->_storeManager = $storeManager;
		parent::__construct($context);
	}
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	public function execute()
    {
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $data = $this->getRequest()->getParams();
        if ($data) {
			
            $model = $this->_objectManager->create('Chilliapple\Customizeproducts\Model\Customizeprodview');
			
			
			$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
						->getDirectoryRead(DirectoryList::MEDIA);

			if(isset($data['view_image']['delete']) && $data['view_image']['delete'] == '1') {
				//echo $mediaDirectory->getAbsolutePath() . $data['view_image']['value'];
				@unlink($mediaDirectory->getAbsolutePath() . $data['view_image']['value']);
				$data['view_image']['value'] = '';
			}
			$filestoUpload = $this->getRequest()->getFiles('view_image');
            if(isset($filestoUpload['name']) && $filestoUpload['name'] != '') {
				try {
					$uploader = $this->_fileUploaderFactory->create(array('fileId' => 'view_image'));
					$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);
					//$config = $this->_objectManager->get('Magento\Bannerslider\Model\Banner');
					$result = $uploader->save($mediaDirectory->getAbsolutePath('customizeproducts/views'));
					unset($result['tmp_name']);
					unset($result['path']);
					$data['view_image'] = $mediaUrl . 'customizeproducts/views'.$result['file'];
					$imageuploaded = true;
				} catch (\Magento\Framework\Model\Exception $e) {
					$data['view_image'] = $mediaUrl . 'customizeproducts/views'.$filestoUpload['name'];
					$imageuploaded = true;
				}
			} else {
				$data['view_image'] = ($data['view_image']['value']?$data['view_image']['value']:'');
			}
			
			$id = ($this->getRequest()->getParam('id')?$this->getRequest()->getParam('id'):'');
            if ($id) {
                $model->load($id);
            }
			
            $model->setData($data);
			
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The Product view has been Saved.'));
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
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the view.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}
