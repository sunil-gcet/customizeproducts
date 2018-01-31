<?php
namespace Chilliapple\Customizeproducts\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
	public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
		\Chilliapple\Customizeproducts\Helper\Data $helperData,
        array $data = []
    ) {
        $this->_catalogLayer = $layerResolver->get();
        $this->_postDataHelper = $postDataHelper;
        $this->categoryRepository = $categoryRepository;
        $this->urlHelper = $urlHelper;
		$this->_helperData = $helperData;
        parent::__construct(
            $context,
			$postDataHelper,
			$layerResolver,
			$categoryRepository,
            $urlHelper
        );
    }
    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
		$_customize_product = 0;
		$pId = $product->getId();
		
		$productOptions = $this->_helperData->getproductOptions($pId);

		if($productOptions['is_customize_product'] && $this->_helperData->getmainSettings('display_customizable')) {
			$html = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->setProduct($product)->setTemplate('Chilliapple_Customizeproducts::product/customizeimage.phtml')->toHtml();
			$renderer = $this->getDetailsRenderer($product->getTypeId());
			if ($renderer) {
				$renderer->setProduct($product);
				return $html.$renderer->toHtml();
			}
			return '';
		} else {
			return '';
		}
    }
}