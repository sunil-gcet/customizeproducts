<?php
namespace Chilliapple\Customizeproducts\Block\Product\View;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;

class Customizepage extends \Magento\Catalog\Block\Product\View
{
	/**
     * @param Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param ProductRepositoryInterface|\Magento\Framework\Pricing\PriceCurrencyInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param array $data
     * @codingStandardsIgnoreStart
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
		\Chilliapple\Customizeproducts\Helper\Data $helperData,
        array $data = []
    ) {
        $this->_productHelper = $productHelper;
        $this->urlEncoder = $urlEncoder;
        $this->_jsonEncoder = $jsonEncoder;
        $this->productTypeConfig = $productTypeConfig;
        $this->string = $string;
        $this->_localeFormat = $localeFormat;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
		$this->_helperData = $helperData;
        parent::__construct(
            $context,
			$urlEncoder,
			$jsonEncoder,
			$string,
			$productHelper,
			$productTypeConfig,
			$localeFormat,
			$customerSession,
			$productRepository,
			$priceCurrency,
            $data
        );
    }
	
	public function getenabledFonts() {
		$google_webfonts = $this->_helperData->getEnabledGoogleFonts();
		$href_wf = "";
		$max_fonts_per_href = 10;
		$href_wfArray = array();
		if (!empty($google_webfonts)) {
			for ($i=0; $i < sizeof($google_webfonts); $i++) {
				array_push($href_wfArray, $google_webfonts[$i]);
				if (($i % $max_fonts_per_href) == $max_fonts_per_href-1 || $i == sizeof($google_webfonts)-1) {
					$href_wf = implode("|", $href_wfArray);
					break;
				}
			}
		}
		return $href_wf;
	}
}