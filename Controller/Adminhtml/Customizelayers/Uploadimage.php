<?php
/**
 *
 * Copyright © 2015 Chilliapplecommerce. All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Controller\Adminhtml\Customizelayers;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Store\Model\StoreManagerInterface;
class Uploadimage extends \Magento\Backend\App\Action
{
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    protected $_fileUploaderFactory;
 
	public function __construct(
		\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
		\Magento\Backend\App\Action\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager
		  
	) {
		$this->_storeManager=$storeManager;
		$this->_fileUploaderFactory = $fileUploaderFactory;
		parent::__construct($context);
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
    /**
     * Ajax action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
		$file_id = 'file';
		if ($this->getRequest()->getFiles($file_id)) {
			
			$folderUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."customizeproducts/elements";
	
			$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);
			$dir = $mediaDirectory->getAbsolutePath('customizeproducts/elements');
			if (!is_dir($dir)) {
				mkdir($dir);
			}
			$filestoUpload = $this->getRequest()->getFiles($file_id);
			$filestoUpload['error'] = array();

			$file_name = $filestoUpload['name'];
			
			if (empty($filestoUpload['error'])) {
				try {
					$uploader = $this->_fileUploaderFactory->create(array('fileId' => $file_id));
					$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);
					$result = $uploader->save($dir);
					unset($result['tmp_name']);
					unset($result['path']);
					
					$filestoUpload['url'] = $folderUrl.$result['file'];
					$filestoUpload['src'] = $folderUrl.$result['file'];
					$filestoUpload['newpath'] = $dir.$result['file'];
					
				} catch (\Magento\Framework\Model\Exception $e) {
					$filestoUpload['error'][] = $e->getMessage();
				}
			}
			$this->getResponse()->setBody(json_encode($filestoUpload));
		}
    }
}
