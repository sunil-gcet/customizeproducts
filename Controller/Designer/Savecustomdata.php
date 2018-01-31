<?php
namespace Chilliapple\Customizeproducts\Controller\Designer;

use Magento\Framework\App\Action\Context;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;

class Savecustomdata extends \Magento\Framework\App\Action\Action
{
	
	/**
     * @var \Magento\Captcha\Helper\Ajaxfunctions
     */
    protected $_ajaxHelper;
	
	
    protected $formKey;
	
	/**
     * @var CustomizeProdRsrce
     */
    protected $_customizeCartdataRsrce;
	
	protected $_filesystem;
	
	protected $_resizeHelper;
	
	protected $_fileUploaderFactory;
	
	protected $_imageFactory;
	
	protected $_storeManager;
	
	protected $cart;
	
	protected $quote;
	
	protected $_checkoutSession;

    /**
     * @param Context $context
     * @param \Chilliapple\Customizeproducts\Helper\Ajaxfunctions $Ajaxfunctions
     */
    public function __construct(
		Context $context,
		\Chilliapple\Customizeproducts\Helper\Ajaxfunctions $Ajaxfunctions,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		FormKey $formKey,
		Customizecartdata $customizeCartdataRes,
		UploaderFactory $fileUploaderFactory,
		AdapterFactory $imageFactory,
		\Magento\Checkout\Model\Cart $cart,
		\Magento\Quote\Model\QuoteFactory $quote,
		\Magento\Checkout\Model\Session $checkoutSession,
		Filesystem $filesystem
	)
    {
        $this->_ajaxHelper = $Ajaxfunctions;
		$this->formKey = $formKey;
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_filesystem = $filesystem;
		$this->_fileUploaderFactory = $fileUploaderFactory;
		$this->_imageFactory = $imageFactory;
		$this->_storeManager = $storeManager;
		$this->cart = $cart;
		$this->quote = $quote;
		$this->_checkoutSession = $checkoutSession;
        parent::__construct($context);
    }
	
	public function execute()
	{
		$errors = array();
		
		$data = $this->getRequest()->getParams();
				
		$product_new_price = $data['price'];
		$fpd_product = $data['fpd_product'];
		$id_product = $data['id_product'];
		$id_product_attribute = $data['ipa'];
		$id_custom_customization = $data['icc'];
		$old_price = $data['old_price'];
		
		$update = false;
		
		if (!$id_custom_customization) {
			$data = array(
				'product_id' => (int)$id_product,
			);
			$this->_customizeCartdataRsrce->setData($data)->save();
			$id_customization_field = $this->_customizeCartdataRsrce->getId();
		} else {
			$id_customization_field = $id_custom_customization;
			$id_customization = $id_custom_customization;
			$update = true;
		}
		
		if (!$id_customization_field) {
			$errors[] = __('An error occurred during the process.');
		}
		if (empty($errors)) {
			
			$filetoUpload = $this->getRequest()->getFiles('thumbimage');
			if (!empty($filetoUpload['name'])) {
				
				$file = $filetoUpload;
				$filename = $file['name'][0];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if (!getimagesize($file['tmp_name'][0]) && $ext !== 'svg') {
					$errors[] = __('This file is not an image!');
				}

				if ($file['error'][0] !== UPLOAD_ERR_OK) {
					$errors[] = $this->_ajaxHelper->fileUploadErrorMessage($file['error'][0]);
				}
				if (empty($errors)) {
					
					$mdname = md5(uniqid(rand(), true));					
					$file_name = $mdname.'.png';
					$file_name_small = $mdname.'_small.png';
					
					$tmpfiledir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()."customizeproducts/tmp/";
					
					is_dir($tmpfiledir) || mkdir($tmpfiledir, 0777, true);
					
					$tmpfilepath = $tmpfiledir.$file_name;
					
					$tmpfileurl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."customizeproducts/tmp/".$file_name;
					
					$filepath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()."customizeproducts/productimages/".$file_name;
					
					$filepathsmall = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()."customizeproducts/productimages/".$file_name_small;
										
					if(move_uploaded_file($file['tmp_name'][0], $tmpfilepath)) {

						list($product_picture_width, $product_picture_height) = getimagesize($tmpfileurl);
					
						if(!$this->imageResize($tmpfilepath, $filepath, $product_picture_width, $product_picture_height)) {
							$errors[] = __('An error occurred during the image upload process.');
						} else if(!$this->imageResize($tmpfilepath, $filepathsmall)) {
							$errors[] = __('An error occurred during the image upload process.');
						} else if (!chmod($filepath, 0777) || !chmod($filepathsmall, 0777)) {
							$errors[] = __('An error occurred during the image upload process.');
						} else {
							
							/*$quoteId = $this->_checkoutSession->getQuote()->getId();
							if(!$quoteId) {
								$store = $this->_storeManager->getStore();
								$quoteObj = $this->quote->create();
								$quoteObj->setStore($store);
								$quoteObj->setCurrency();
								$quoteObj->save();
								$quoteId = $quoteObj->getId();
							}*/
							
							$data = array(
								'id' => $id_customization_field,
								'session_id' => session_id(),
								'image_name' => $mdname,
								'data' => $fpd_product,
								'new_price' => (float)$product_new_price,
								'old_price' => (float)$old_price
								);
							$this->_customizeCartdataRsrce->setData($data)->save();
														
							$this->savetoSession($id_customization_field);
						}
					}
				}
				unlink($tmpfilepath);
			}
			
			$return = array();
			$return['hasError'] = false;
			$return['update'] = $update;
			$return['id_customization'] = $id_customization_field;
			
		} else {
			$return = array();
			$return['hasError'] = true;
			$return['errors'] = $errors;
		}
		//echo json_encode($return);
		//exit;
		$this->getResponse()->setBody(json_encode($return));
	}
	
	public function savetoSession($id_customization_field) {
		
		$sArray = array();
		$sArray = $this->_checkoutSession->getcustomizedData();
		if(count($sArray) && is_array($sArray)) {
			if(!in_array($id_customization_field, $sArray)) {
				$sArray[] = $id_customization_field;
				$this->_checkoutSession->setcustomizedData($sArray);
			}
		} else {
			$this->_checkoutSession->setcustomizedData(array($id_customization_field));
		}
	}
	
	public function imageResize($src, $dest, $width=64, $height=64) {
		
		try {
			$imageResize = $this->_imageFactory->create();
			$imageResize->open($src);
			$imageResize->backgroundColor([255, 255, 255]);
			$imageResize->constrainOnly(TRUE);
			$imageResize->keepTransparency(TRUE);
			$imageResize->keepFrame(true);
			$imageResize->keepAspectRatio(true);
			$imageResize->resize($width,$height);
			$imageResize->save($dest);
			return true;
		}
		catch (\Magento\Framework\Model\Exception $e) {
			return false;
		}
    }
}