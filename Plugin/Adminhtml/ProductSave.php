<?php

namespace Chilliapple\Customizeproducts\Plugin\Adminhtml;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Image\AdapterFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Magento\Catalog\Controller\Adminhtml\Product\Save\Interceptor;
use Magento\Backend\Model\View\Result\Redirect\Interceptor as RedirectInterceptor;
use Chilliapple\Customizeproducts\Model\CustomizeDataFactory;

/**
 * Class ProductSave
 * 
 * @package Chilliapple\Customizeproducts\Plugin\Adminhtml
 */
class ProductSave
{

    /**
     * @var ManagerInterface
     */
    private $_messageManager;

    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * @var UploaderFactory
     */
    private $uploader;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var CustomizeDataFactory
     */
    private $customizeDataFactory;

    /**
     * ProductSave constructor.
     *
     * @param ManagerInterface $messageManager
     * @param AdapterFactory $adapterFactory
     * @param UploaderFactory $uploader
     * @param Filesystem $filesystem
     * @param RequestInterface $request
     * @param Registry $registry
     * @param CustomizeDataFactory $customizeDataFactory
     */
    public function __construct(
        ManagerInterface $messageManager,
        AdapterFactory $adapterFactory,
        UploaderFactory $uploader,
        Filesystem $filesystem,
        RequestInterface $request,
        Registry $registry,
        CustomizeDataFactory $customizeDataFactory
    ) {
        $this->_messageManager = $messageManager;
        $this->adapterFactory = $adapterFactory;
        $this->uploader = $uploader;
        $this->filesystem = $filesystem;
        $this->request = $request;
        $this->registry = $registry;
        $this->customizeDataFactory = $customizeDataFactory;
    }

    /**
     * Save custom description by plugin method
     *
     * @param Interceptor $subject
     * @param RedirectInterceptor $result
     *
     * @return RedirectInterceptor
     */
    public function afterExecute(Interceptor $subject, RedirectInterceptor $result)
    {
        $params = $this->request->getParams();
		$data = array();
        $product = $this->registry->registry('current_product');
		
		$customizeData = (isset($params['product']['customize_data'])?$params['product']['customize_data']:'');

        if ($product && is_array($customizeData)) {
            $data['id_product'] = $productId = $product->getId();			
			
			//echo "<pre>";
			//print_r($customizeData);
			
			$data['_customize_product'] = $customizeData['allow_customization'];
			
			if (isset($customizeData['customize_products'])) {
				$data['cpd_products'] = serialize($customizeData['customize_products']);
			}
			if (isset($customizeData['customize_categories'])) {
				$data['cpd_product_categories'] = serialize($customizeData['customize_categories']);
			}
			$data['cpd_source_type'] = $customizeData['source_type'];
			
			$product_customization_id = $customizeData['product_customization_id'];

			unset($customizeData['allow_customization'], $customizeData['source_type'], $customizeData['customize_products'], $customizeData['product_customization_id']);
			
			$data['cpd_product_settings'] = json_encode($customizeData);

            if (is_array($customizeData) && !empty($productId)) {
                /* @var $customDescription \Chilliapple\Customizeproducts\Model\CustomizeData */
                $customizeProductData = $this->customizeDataFactory->create();

				if (isset($product_customization_id) && $product_customization_id) {
					$item = $customizeProductData->load($product_customization_id);
				} else {
					$item = $customizeProductData;
				}
				
				$item->addData($data);
				try {
					$item->save();
					$item->unsetData();
				} catch (\Exception $e) {
					$this->_messageManager->addError(__("Couldn't save changes on custom description"));
				}				
            }
        }
        return $result;
    }

}