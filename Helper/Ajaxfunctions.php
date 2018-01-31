<?php
/**
 * Copyright © 2015 Chilliapple . All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Helper;

use Chilliapple\Customizeproducts\Model\Customsettings;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\StoreManagerInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
use Chilliapple\Customizeproducts\Model\Customizeprod;
use Chilliapple\Customizeproducts\Model\Customizeprodview;

class Ajaxfunctions extends \Magento\Framework\App\Helper\AbstractHelper
{
	
	protected $_image_upload_path = 'customizeproducts/customized-product/';
	/**
     * @var MainsettingsDataRsrce
     */
    protected $_mainsettingsDataRsrce;
	
	protected $_fileUploaderFactory;
	
	/**
     * @var StoreManager
     */
	protected $_storeManager;
	
	protected $_fileSystemFactory;
	
	protected $_customizeCartdataRsrce;
	
	protected $_customizeProdRsrce;
	
	protected $_customizeProdViewRsrce;
	
	protected $_directory_list;
	
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		Customsettings $mainsettingsDataRes,
		UploaderFactory $fileUploaderFactory,
		Filesystem $filesystemFactory,
		Customizecartdata $customizeCartdataRes,
		Customizeprod $customizeProdRes,
		Customizeprodview $customizeProdView,
		DirectoryList $directory_list,
		//Tcpdfinit $tcpdfinit,
		StoreManagerInterface $storeManager
	) {
		
		parent::__construct($context);
		$this->_fileUploaderFactory = $fileUploaderFactory;
		$this->_fileSystemFactory = $filesystemFactory;
		$this->_storeManager = $storeManager;
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_customizeProdRsrce = $customizeProdRes;
		$this->_customizeProdViewRsrce = $customizeProdView;
		$this->_directory_list = $directory_list;
		//$this->_tcpdfinit = $tcpdfinit;
		$this->_mainsettingsDataRsrce = $mainsettingsDataRes->load(1)->getData();

	}
	
	public function getallfoldersPath($name) {
		
		$mediaPath = $this->_directory_list->getPath('media');
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		
		$folderArray['libpath'] = $this->_directory_list->getPath('app').'/code/Chilliapple/Customizeproducts/lib/';
		$folderArray['orderpath'] = $mediaPath.'/customizeproducts/customize_products_orders/';
		$folderArray['orderurl'] = $mediaUrl.'customizeproducts/customize_products_orders/';
		$folderArray['orderimagepath'] = $folderArray['orderpath'].'/images/';
		$folderArray['orderimageurl'] = $folderArray['orderurl'].'images/';
		$folderArray['orderpdfpath'] = $folderArray['orderpath'].'/pdfs/';
		$folderArray['orderpdfurl'] = $folderArray['orderurl'].'pdfs/';
		
		return $folderArray[$name];
		
	}
	
	public function getmainSettings($key='') {
		
		if($key == '') {
			//echo "<br>no key -- return main";
			return $this->_mainsettingsDataRsrce;
		} else {
			//echo "<br>key -- return main --".$key;
			if(isset($this->_mainsettingsDataRsrce[$key]) && $this->_mainsettingsDataRsrce[$key]!='') {
				return $this->_mainsettingsDataRsrce[$key];
			}
		}
		return '0';
	}
	
	function file_upload_error_message($error_code)
	{
		switch ($error_code) {
			case UPLOAD_ERR_INI_SIZE:
				return __(
					'The uploaded file exceeds the upload_max_filesize directive in php.ini'
				);
			case UPLOAD_ERR_FORM_SIZE:
				return __(
					'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'
				);
			case UPLOAD_ERR_PARTIAL:
				return __('The uploaded file was only partially uploaded');
			case UPLOAD_ERR_NO_FILE:
				return __('No file was uploaded');
			case UPLOAD_ERR_NO_TMP_DIR:
				return __('Missing a temporary folder');
			case UPLOAD_ERR_CANT_WRITE:
				return __('Failed to write file to disk');
			case UPLOAD_ERR_EXTENSION:
				return __('File upload stopped by extension');
			default:
				return __('Unknown upload error');
		}

	}
	
	function get_image_dpi($filename)
	{
		$image = fopen($filename, 'r');
		$string = fread($image, 20);
		fclose($image);
		$data = bin2hex(substr($string, 14, 4));
		$x = substr($data, 0, 4);
		$y = substr($data, 0, 4);
		return array(hexdec($x), hexdec($y));

	}
	
	function sanitize_file_name($filename)
	{

		$filename = preg_replace("#\x{00a0}#siu", ' ', $filename);
		$filename = str_replace(array('%20', '+'), '-', $filename);
		$filename = preg_replace('/[\r\n\t -]+/', '-', $filename);
		$filename = trim($filename, '.-_');

		$parts = explode('.', $filename);

		if (count($parts) <= 2) {
			return $filename;
		}

		$filename = array_shift($parts);
		$extension = array_pop($parts);

		foreach ((array) $parts as $part) {
			$filename .= '.' . $part;
		}
		$filename .= '.' . $extension;

		return $filename;
	}
	
	function upload_image($data, $files) {
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		$mb_size =  $this->getmainSettings('max_image_size'); //in MB
        if($mb_size == 0) {
            $mb_size = 5; //Default 5 MB size
        }
		$maximum_filesize = $mb_size * 1024 * 1000;
		foreach ($files as $file) {
			$filename = $file['name'];
			//check if its an image
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if (!getimagesize($file['tmp_name']) && $ext !== 'svg') {
				return json_encode(
					array(
						'code' => 500,
						'message' => __('This file is not an image!'),
						'filename' => $file['name']
					)
				);
			}
			//check for php errors
			if ($file['error'] !== UPLOAD_ERR_OK) {
				return json_encode(
					array(
						'code' => 500,
						'message' => $this->file_upload_error_message($file['error']),
						'filename' => $filename
					)
				);
			}
			//check for maximum upload size
			if ($file['size'] > $maximum_filesize) {
				return json_encode(
					array(
						'code' => 500,
						'message' => __('Uploaded image is too big! Maximum image size is '.$maximum_filesize.' MB!'),
						'filename' => $filename
					)
				);
			}
			//check the minimum DPI
			$dpi = $this->get_image_dpi($file['tmp_name']);
			
			$min_dpi = $this->getmainSettings('min_dpi');
			if (isset($dpi[0]) && $dpi[0] !== 0 && $dpi[0] < $min_dpi) {
				return json_encode(array(
					'code' => 500,
					'message' => __('The DPI of the uploaded image is too small! Minimum allowed DPI is '.$min_dpi.'.'),
					'filename' => $filename
				));
			}
			//check dimensions
			$image_dimensions = getimagesize($file['tmp_name']);
			try {
				$uploader = $this->_fileUploaderFactory->create(['fileId' => 'uploaded_file']);
				$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
				$uploader->setAllowRenameFiles(true);
				$uploader->setFilesDispersion(false);
				$path = $this->_fileSystemFactory->getDirectoryRead(DirectoryList::MEDIA)
				->getAbsolutePath($this->_image_upload_path);
				$result = $uploader->save($path);
				$img_url = $mediaUrl.$this->_image_upload_path.$result['file'];
				return json_encode(array(
					'code' => 200,
					'url' => $img_url,
					'filename' => preg_replace("/\\.[^.\\s]{3,4}$/", "", $result['file']),
					'dim' => $image_dimensions
				));
			} catch (\Magento\Framework\Model\Exception $e) {
				return json_encode(array(
					'error' => 2,
					'message' => $e->getMessage(),
					'filename' => preg_replace("/\\.[^.\\s]{3,4}$/", "", $result['file'])
				));
			}
		}
		return json_encode(array());
	}
	
	public function upload_social_image($data) {
		$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		$url = $data['url'];
		$img_formats = array("image/png", "image/jpg", "image/jpeg");
		$img_info = getimagesize($url);

		if (!in_array(strtolower($img_info['mime']), $img_formats)) {
			return json_encode(array('error' => 'This is not an image file!'));
		}
		$url_new = preg_replace('/\?.*/', '', $url);
		$filename = basename($url_new);
		$filename =  $this->sanitize_file_name($filename);
		$path = $this->_fileSystemFactory->getDirectoryRead(DirectoryList::MEDIA)
				->getAbsolutePath($this->_image_upload_path);
		$file_path = $path . $filename;
		$im_ul = $mediaUrl.$this->_image_upload_path;

		if (copy($url, $file_path)) {
			$img_url =  $im_ul.$filename;
			return json_encode(array('image_src' => $img_url));
		} else {
			return json_encode(array(
				'error' => __('PHP Issue - copy image failed')
			));
		}
		
	}
	
	public function load_order($data) {
				
		$ic = $data['ic'];
		$pi = $data['pi'];
		
		if (!$ic) {
			return json_encode(array());
		}
		
		$customData = $this->_customizeCartdataRsrce->getCustomizedcartdata(array($ic));

		header('Content-Type: application/json');

		if ($customData && isset($customData[0]['data'])) {
			$views = $customData[0]['data'];
			return json_encode(
				array(
					'order_data' => $views
				)
			);
		}
		return json_encode(array());
	}
	
	public function load_order_item_images($data) {
		
		$ic = $data['item_id'];
		$order_id = $data['order_id'];
		if (!($ic && $order_id)) {
			return json_encode(array());
		}

		$order_id = trim($order_id);
		$item_id = trim($ic);

		$pic_types = array("jpg", "jpeg", "png", "svg");
		
		$item_dir_url = $this->getallfoldersPath('orderimageurl').$order_id.'/'.$item_id;
		$item_dir = $this->getallfoldersPath('orderimagepath').$order_id.'/'.$item_id;
		//@mkdir($mediaPath.'/customize_products_orders');
		//@mkdir($mediaPath.'/customize_products_orders/images');
		//mkdir($mediaPath.'/customize_products_orders/images/'.$order_id);
		//mkdir($mediaPath.'/customize_products_orders/images/'.$order_id.'/'.$item_id);
		//mkdir($item_dir, 777, true);
		
		header('Content-Type: application/json');
		
		if (file_exists($item_dir)) {
			$folder = opendir($item_dir);
			$images = array();
			while ($file = readdir($folder)) {
				if (in_array(substr(strtolower($file), strrpos($file, ".") + 1), $pic_types)) {
					$images[] = $item_dir_url.'/'.$file;
				}
			}
			closedir($folder);
			return json_encode(array('code' => 200, 'images' =>  $images));
		} else {
			return json_encode(array('code' => 201));
		}
		return json_encode(array());		
	}
	
	function create_pdf_from_dataurl($data, $files) {
		
		$order_id = $data['order_id'];
		if ($data['format'] != 'svg') {
			$data_strings = $files;
		} else {
			$data_strings = explode(
				'<!--?xml version="1.0" encoding="UTF-8" standalone="no" ?-->',
				$data['data_strings']
			);
			foreach ($data_strings as $key => $data_value) {
				$data_value = rtrim(trim($data_value), ',');
				if (empty($data_value)) {
					unset($data_strings[$key]);
				} else {
					$data_strings[$key] = '<!--?xml version="1.0" encoding="UTF-8" standalone="no" ?-->'.$data_value;
				}
			}
			$data_strings = array_values($data_strings);
		}
		
		if (!($order_id && $data_strings)) {
			return json_encode(array());
		}
		
		$order_id = trim($order_id);
		$item_id = trim($data['item_id']);

		$width = trim($data['width']);
		$height = trim($data['height']);
		$image_format = trim($data['image_format']);
		$orientation = trim($data['orientation']);
		$dpi = $data['dpi'] ? (int)$data['dpi'] : 300;
		
		//create product orders directory
		$cpd_order_dir = $this->getallfoldersPath('orderpath');

		if (!is_dir($cpd_order_dir)) {
			mkdir($cpd_order_dir);
		}

		//create pdf dir
		$pdf_dir = $cpd_order_dir.'pdfs/';
		$pdf_path = $pdf_dir.$order_id.'_'.$item_id.'.pdf';
		if (!is_dir($pdf_dir)) {
			mkdir($pdf_dir);
		}

		$pdf = new \TCPDF($orientation, 'mm', array($width, $height), true, 'UTF-8', false);

        
		// set document information
		$pdf->SetCreator($this->_storeManager->getStore()->getBaseUrl());
		$pdf->SetTitle($order_id);

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//if memory limit is too small, a fatal php error will thrown here
		foreach ($data_strings as $data_str) {
			$pdf->AddPage();
			if ($image_format == 'svg') {
				if (!class_exists('Svgdocument')) {
					new \Svglib_Svgdocument($svg);
				}
				$pdf->ImageSVG('@'.$data_str);
			} else {
				$data_str = file_get_contents($data_str['tmp_name'][0]);
				$pdf->Image('@'.$data_str, '', '', 0, 0, '', '', '', false, $dpi);
			}
		}
		$pdf->Output($pdf_path, 'F');

		$pdf_url = $this->getallfoldersPath('orderurl').'pdfs/'.$order_id.'_'.$item_id.'.pdf';

		header('Content-Type: application/json');
		return json_encode(array('code' => 201, 'url' => $pdf_url));
	}
	
	public function new_product($postData) {
		
		if ($postData['title'] == '') {
			return json_encode(array());
		}
		$data['title'] = $postData['title'];
				
		$id = $this->_customizeProdRsrce->create($data);

		$suc = __('Product successfully created!');

		header('Content-Type: application/json');
		return json_encode(
			array(
				'id' => $this->_customizeProdRsrce->getId(),
				'message' => $id ? $suc : __('Product could not be created. Please try again!'),
				'html' => $this->_customizeProdRsrce->getProductItemHtml($id, $data['title'], '', '')
			)
		);
	
	}
	
	public function new_view($postData) {
		
		if ($postData['title'] == '' || $postData['product_id'] == ' ') {
			return json_encode(array());
		}

		$title = trim($postData['title']);
		$thumbnail = trim($postData['thumbnail']);
		$product_id = trim($postData['product_id']);

		if ($postData['elements']) {
			$elements = $postData['elements'];
		} else {
			$elements = false;
		}

		//check if elements are posted
		if ($elements !== false) {

			$elements = json_decode(stripslashes($elements), true);
			//serialize for database
			$elements = serialize($elements);

		}
		
		$view_id = $this->_customizeProdViewRsrce->addView($product_id, $title, $elements, $thumbnail);

		//send answer
		header('Content-Type: application/json');

		if ($view_id) {
			return json_encode(array('html' => $this->_customizeProdRsrce->getViewItemHtml($view_id, $thumbnail, $title, '')));
		} else {
			return json_encode(array());
		}
		
	}
	
	function create_image_from_dataurl($postData, $files) {
		
		$order_id = trim($postData['order_id']);
		$item_id = trim($postData['item_id']);
		$data_url = $files['data_url'];
		$title = trim($postData['title']);
		$format = trim($postData['format']);
		if (!($order_id && $item_id && $data_url && $title && $format)) {
			return json_encode(array());
		}

		/*$order_id = trim($postData['order_id']);
		$item_id = trim($postData['item_id']);
		$data_url = $files['data_url'];
		$format = trim($postData['format']);
		$dpi = $postData['dpi'] ? (int)$postData['dpi'] : 300;
		$title = Tools::link_rewrite(Tools::safeOutput(trim($postData['title'])));*/
		
		$filename = preg_replace("/[^a-zA-Z0-9]+/", "", $title);

		//create product orders directory
		$images_dir = $this->getallfoldersPath('orderimagepath');
		if (!is_dir($images_dir)) {
			mkdir($images_dir);
		}

		//create order dir
		$order_dir = $images_dir . $order_id . '/';
		if (!is_dir($order_dir)) {
			mkdir($order_dir);
		}

		//create item dir
		$item_dir = $order_dir . $item_id . '/';
		if (!is_dir($item_dir)) {
			mkdir($item_dir);
		}

		$image_path = $item_dir.$filename.'.'.$format;
		$image_exist = file_exists($image_path);
		$result = move_uploaded_file($data_url['tmp_name'], $image_path);

		if ($format == 'jpeg') {
			$source = imagecreatefromjpeg($image_path);
			list($width, $height) = getimagesize($image_path);
			$resampler = new \Resampler_Resampler();
			$im = $resampler->resample($source, $height, $width, $dpi);
			file_put_contents($image_path, $im);
		}

		header('Content-Type: application/json');
		if ($result) {
			$image_url = $this->getallfoldersPath('orderimageurl').$order_id.'/'.$item_id . '/'.$filename.'.'.$format;
			return json_encode(array('code' => $image_exist ? 302 : 201, 'url' => $image_url, 'title' => $filename));
		} else {
			return json_encode(array('code' => 500));
		}
		
	}
	function create_image_from_svg($postData) {
		
		$order_id = $postData['order_id'];
		$item_id = $postData['item_id'];
		$svg = $postData['svg'];
		$title = $postData['title'];
		if (!($order_id && $item_id && $svg && $title)) {
			return json_encode(array());
		}
		
		$order_id = trim($postData['order_id']);
		$item_id = trim($postData['item_id']);
		$svg = stripslashes(trim($postData['svg']));
		$width = trim($postData['width']);
		$height = trim($postData['height']);
		$title = trim($postData['title']);
		
		$filename = preg_replace("/[^a-zA-Z0-9]+/", "", $title);

		//create image dir
		$images_dir = $this->getallfoldersPath('orderimagepath');
		if (!is_dir($images_dir)) {
			mkdir($images_dir);
		}

		//create order dir
		$order_dir = $images_dir . $order_id . '/';
		if (!is_dir($order_dir)) {
			mkdir($order_dir);
		}

		//create item dir
		$item_dir = $order_dir . $item_id . '/';
		if (!is_dir($item_dir)) {
			mkdir($item_dir);
		}

		$image_path = $item_dir.$filename.'.svg';

		$image_exist = file_exists($image_path);

		header('Content-Type: application/json');
		try {
			$svg = '<?xml version="1.0" encoding="UTF-8" standalone="no" ?>
						<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
						width="'.$width.'" height="'.$height.'" xml:space="preserve">'.$svg.'</svg>';
			
			
			
			$svg_doc = new \Svglib_Svgdocument($svg);
			$svg_doc->asXML($image_path);

			$image_url = $this->getallfoldersPath('orderimageurl').$order_id.'/'.$item_id . '/'.$filename.'.svg';
			return json_encode(
				array(
					'code' => $image_exist ? 302 : 201,
					'url' => $image_url,
					'title' => $filename
				)
			);
		} catch (\Magento\Framework\Model\Exception $e) {
			return json_encode(array('code' => 500));
		}
		return json_encode(array());
	}
}