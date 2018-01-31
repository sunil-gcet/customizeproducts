<?php

namespace Chilliapple\Customizeproducts\Block\Adminhtml\Product\Edit\Tab\CustomizeData;

use Magento\Backend\Block\Widget;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;
use Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData;

/**
 * Class Data
 *
 * @package Chilliapple\Customizeproducts\Block\Adminhtml\Product\Edit\Tab\CustomizeData
 */
class Data extends Widget
{
    /**
     * @var Product
     */
    protected $_productInstance;

    /**
     * @var string
     */
    protected $_template = 'Chilliapple_Customizeproducts::catalog/product/edit/tab/data.phtml';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var Product
     */
    protected $_product;

    /**
     * @var int
     */
    protected $_itemCount = 1;

    /**
     * @var CustomizeData
     */
    protected $_customizeDataResource;
	
	protected $_modelProd;
	
	protected $_modelCat;
	
	protected $_helperData;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param Product $product
     * @param Registry $registry
     * @param array $data
     * @param CustomizeData $customizeDataResource
     */
    public function __construct(
        Context $context,
        Product $product,
        Registry $registry,
        array $data = [],
        CustomizeData $customizeDataResource,
		\Chilliapple\Customizeproducts\Model\Customizeprod $prodModel,
		\Chilliapple\Customizeproducts\Model\Productcategory $catModel,
		\Chilliapple\Customizeproducts\Helper\Data $helperData
    ) {
        $this->_product = $product;
        $this->_coreRegistry = $registry;
        $this->_customizeDataResource = $customizeDataResource;
		$this->_helperData = $helperData;
		$this->_modelProd = $prodModel;
		$this->_modelCat = $catModel;
		
        parent::__construct($context, $data);
    }
	
	public function getHelperData($type) {
		
		if($type == 'frame_shadow') {
			return $this->_helperData->getFrameShadows();
		} else if($type == 'dialog_box') {
			return $this->_helperData->getDialogBoxPositionings();
		} else if($type == 'view_selection') {
			return $this->_helperData->getViewSelectionPosititionsOptions();
		} else if($type == 'enabled_fonts') {
			return $this->_helperData->getEnabledFonts();
		} else if($type == 'status_options') {
			return $this->_helperData->getStatusOptions();
		}
		
	}
	
	/**
     * Get Customize Product
     *
     * @return Customize Product
     */
    public function getcustomizeProduct() {
		$prodCollection = $this->_modelProd->getCollection();
		$collectionData = $prodCollection->getData();
		return $collectionData;
	}
	
	/**
     * Get Customize Product
     *
     * @return Customize Product
     */
    public function getcustomizeCategories() {
		$catCollection = $this->_modelCat->getCollection();
		$collectionData = $catCollection->getData();
		return $collectionData;
	}

    /**
     * Get Product
     *
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->_productInstance) {
            $product = $this->_coreRegistry->registry('product');
            if ($product) {
                $this->_productInstance = $product;
            } else {
                $this->_productInstance = $this->_product;
            }
        }

        return $this->_productInstance;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->_productInstance = $product;
        return $this;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * Get custom description by the current product
     *
     * @return array
     */
    public function getCustomizeData()
    {
        $productId = $this->getRequest()->getParam('id', false);

        if ($productId) {
            $customizeData = $this->_customizeDataResource
                ->getCustomizeDataByProductId($productId);
			if(count($customizeData->getData())) {
				$returnData = $customizeData->getData()[0];
				$returnData['cpd_products'] = unserialize($returnData['cpd_products']);
				$returnData['cpd_product_categories'] = unserialize($returnData['cpd_product_categories']);
				$returnData['cpd_product_settings'] = json_decode($returnData['cpd_product_settings']);
				return $returnData;
			}
			
        }
		
		return [];
		
    }

}
