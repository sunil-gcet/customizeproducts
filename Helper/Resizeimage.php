<?php
/**
 * Copyright © 2015 Chilliapple . All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Filesystem\DirectoryList;

class Resizeimage extends AbstractHelper{

    protected $_filesystem;
    protected $_storeManager;
    protected $_directory;
    protected $_imageFactory;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory

    ) {
        $this->_filesystem = $filesystem;
        $this->_storeManager = $storeManager;
        $this->_directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_imageFactory = $imageFactory;

    }


    public function imageResize($src, $width=64, $height=64, $dir = 'customizeproducts/productimages/') {
		
        $absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath().$src;

        $imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath($dir).$this->getNewDirectoryImage($src);
        $imageResize = $this->_imageFactory->create();

        $imageResize->open($absPath);
        $imageResize->backgroundColor([255, 255, 255]);
        $imageResize->constrainOnly(TRUE);
        $imageResize->keepTransparency(TRUE);
        $imageResize->keepFrame(true);
        $imageResize->keepAspectRatio(true);

        $imageResize->resize($width,$height);
        $dest = $imageResized ;
        $imageResize->save($dest);
        $resizedURL= $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).$dir.$this->getNewDirectoryImage($src);
        return $resizedURL;
    }

    public function getNewDirectoryImage($src){
        $segments = array_reverse(explode('/',$src));
        $first_dir = substr($segments[0],0,1);
        $second_dir = substr($segments[0],1,1);
        return 'cache/'.$first_dir.'/'.$second_dir.'/'.$segments[0];
    }
}