<?php
/**
 * Copyright © 2015 Chilliapple . All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Helper;

use Chilliapple\Customizeproducts\Model\Cdresource\CustomizeData;
use Chilliapple\Customizeproducts\Model\Customizeprod;
use Chilliapple\Customizeproducts\Model\Customizeprodview;
use Chilliapple\Customizeproducts\Model\Customsettings;
use Chilliapple\Customizeproducts\Model\Productcategory;
use Chilliapple\Customizeproducts\Model\Customizedesign;
use Chilliapple\Customizeproducts\Model\Customizecartdata;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	
	/**
     * @var CustomizeDataRsrce
     */
    protected $_customizeDataRsrce;
	
	/**
     * @var CustomizeProdRsrce
     */
    protected $_customizeProdRsrce;
	
	/**
     * @var MainsettingsDataRsrce
     */
    protected $_mainsettingsDataRsrce;
	
	/**
     * @var MainsettingsDataRsrce
     */
    protected $_productsettingsData;
	
	/**
     * @var ProdCategoryRsrce
     */
	protected $_prodCategoryRsrce;
	
	/**
     * @var ProdCategoryRsrce
     */
	protected $_customDesignRsrce;
	
	/**
     * @var StoreManager
     */
	protected $_storeManager;
	
	protected $_customizeCartdataRsrce;
	
	protected $_debug = false;	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		CustomizeData $customizeDataRes,
		Customsettings $mainsettingsDataRes,
		Customizeprod $customizeProdRes,
		Customizeprodview $customizeProdviewRes,
		Productcategory $prodCategoryRes,
		Customizedesign $customDesignRes,
		StoreManagerInterface $storeManager,
		Customizecartdata $customizeCartdataRes,
		\Magento\Framework\View\Asset\Repository $assetRepo
	) {
		parent::__construct($context);
		$this->_customizeDataRsrce = $customizeDataRes;
		$this->_customizeProdRsrce = $customizeProdRes;
		$this->_customizeProdviewRsrce = $customizeProdviewRes;
		$this->_prodCategoryRsrce = $prodCategoryRes;
		$this->_customDesignRsrce = $customDesignRes;
		$this->_storeManager = $storeManager;
		$this->_customizeCartdataRsrce = $customizeCartdataRes;
		$this->_assetRepo = $assetRepo;
		$this->_mainsettingsDataRsrce = $mainsettingsDataRes->load(1)->getData();
	}
	
	/**
	 * Get the available frame shadows.
	 *
	 */
	public static function getFrameShadows()
	{
		return array(
			0 => array('label' => __('Shadow 1'), 'value' => 'fpd-shadow-1'), 
			1 => array('label' => __('Shadow 2'), 'value' => 'fpd-shadow-2'), 
			2 => array('label' => __('Shadow 3'), 'value' => 'fpd-shadow-3'), 
			3 => array('label' => __('Shadow 4'), 'value' => 'fpd-shadow-4'), 
			4 => array('label' => __('Shadow 5'), 'value' => 'fpd-shadow-5'), 
			5 => array('label' => __('Shadow 6'), 'value' => 'fpd-shadow-6'), 
			6 => array('label' => __('Shadow 7'), 'value' => 'fpd-shadow-7'), 
			7 => array('label' => __('Shadow 8'), 'value' => 'fpd-shadow-8'),
			8 => array('label' => __('No Shadow'), 'value' => 'fpd-no-shadow'));

	}

	/**
	 * Get the available dialog box positionings.
	 *
	 */
	public static function getDialogBoxPositionings()
	{
		
		return array(
			0 => array('label' => __('Dynamic'), 'value' => 'dynamic'), 
			1 => array('label' => __('Fixed Left'), 'value' => 'left'), 
			2 => array('label' => __('Fixed Right'), 'value' => 'right'));

	}

	/**
	 * Get the view selection positions options
	 *
	 */
	public static function getViewSelectionPosititionsOptions()
	{
		return array(
			0 => array('label' => __('Top-Right in Product Stage'), 'value' => 'tr'), 
			1 => array('label' => __('Top-Left in Product Stage'), 'value' => 'tl'), 
			2 => array('label' => __('Bottom-Right in Product Stage'), 'value' => 'br'), 
			3 => array('label' => __('Bottom-Left in Product Stage'), 'value' => 'bl'), 
			4 => array('label' => __('Under the Product Stage'), 'value' => 'outside'));

	}
	/**
	 * Get the status selection positions options
	 *
	 */
	public static function getStatusOptions()
	{
		return array(0 => array('label' => __('No'), 'value' => '0'), 1 => array('label' => __('Yes'), 'value' => '1'));

	}
	/**
	 * Get the filters selection positions options
	 *
	 */
	public static function getFiltersOptions()
	{
		return array(0 => array('label' => __('Grayscale'), 'value' => 'grayscale'), 1 => array('label' => __('Sepia'), 'value' => 'sepia'), 2 => array('label' => __('Sepia 2'), 'value' => 'sepia2'));

	}
	/**
	 * Get the status selection positions options
	 *
	 */
	public static function getAlignmentOptions()
	{
		return array(0 => array('label' => __('Left'), 'value' => 'left'), 1 => array('label' => __('Center'), 'value' => 'center'), 2 => array('label' => __('Right'), 'value' => 'right'));

	}
	/**
	 * Get the status selection positions options
	 *
	 */
	public static function getOriginOptions()
	{
		return array(0 => array('label' => __('Left'), 'value' => 'left'), 1 => array('label' => __('Center'), 'value' => 'center'));

	}
	public static function getGoogleWebfonts()
	{
		$fpd_google_client_id = '';
		
		$optimised_google_webfonts = array();
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		$pproCollection = $objectManager->create('Chilliapple\Customizeproducts\Model\ResourceModel\Customsettings\Collection');
		$pproCollection->getSelect()->where("main_table.id = '1'");
		$pData = $pproCollection->getData();
		foreach($pData as $data) {
			
			$fpd_google_client_id = @$data['google_font_client_id'];
			
		}
		if($fpd_google_client_id != '') {
			
			$google_webfonts = false;

			$url = 'https://www.googleapis.com/webfonts/v1/webfonts';
			$url .= '?key='.$fpd_google_client_id;
			
			if (function_exists('curl_init')) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL, $url);
				$google_webfonts = curl_exec($ch);
				curl_close($ch);
			}

			if ($google_webfonts === false && function_exists('file_get_contents')) {
				$google_webfonts = file_get_contents($url);
			}

			if ($google_webfonts !== false) {

				$google_webfonts = json_decode($google_webfonts);
				$optimised_google_webfonts = array();

				if (isset($google_webfonts->items)) {
					$i = 0;
					foreach ($google_webfonts->items as $item) {
						foreach ($item->variants as $variant) {
							$key = str_replace(' ', '+', $item->family).':'.$variant;
							$optimised_google_webfonts[$i]['label'] = $item->family. ' '. $variant;
							$optimised_google_webfonts[$i]['value'] = $key;
							$i++;
						}
					}
				}
			}
		}
		return $optimised_google_webfonts;

	}
	/**
	 * Get woff fonts
	 *
	 * @return array
	 */
	public static function getWoffFonts()
	{
		//load woff fonts from fonts directory
		$woff_files = array();
		$fonts_dir = BP.'/app/code/Chilliapple/Customizeproducts/view/base/web/fonts/';

		if (file_exists($fonts_dir)) {

			$files = scandir($fonts_dir);
			$i = 0;
			foreach ($files as $file) {
				if (preg_match("/.woff/", strtolower($file))) {
					//$woff_files[$file] = str_replace('_', ' ', preg_replace("/\\.[^.\\s]{3,4}$/", "", $file));
					$woff_files[$i]['label'] = str_replace('_', ' ', preg_replace("/\\.[^.\\s]{3,4}$/", "", $file));
					$woff_files[$i]['value'] = $file;
					
					$i++;
				}
			}

		}
		return $woff_files;

	}
	
	/**
	 * Get enabled fonts
	 *
	 * @return array
	 */
	public static function getEnabledFonts()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$fontsModel = $objectManager->create('Chilliapple\Customizeproducts\Model\Customsettings');
		$fontsData = $fontsModel->load(1);
		$_mainSettings = $fontsData->getData();
		
		$all_fonts = array();
		$common_fonts = explode(",", $_mainSettings['common_fonts']);
		$all_fonts = array_merge($common_fonts, $all_fonts);
		$google_webfonts = explode(",", $_mainSettings['google_webfonts']);
		$all_fonts = array_merge($google_webfonts, $all_fonts);
		$fonts_directory = explode(",", $_mainSettings['fonts_directory']);
		$all_fonts = array_merge($fonts_directory, $all_fonts);
		asort($all_fonts);
		return $all_fonts;
		
	}
	
	/**
	 * Get enabled fonts
	 *
	 * @return array
	 */
	public static function getEnabledGoogleFonts()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$fontsModel = $objectManager->create('Chilliapple\Customizeproducts\Model\Customsettings');
		$fontsData = $fontsModel->load(1);
		$_mainSettings = $fontsData->getData();
		
		$all_fonts = array();
		$google_webfonts = explode(",", $_mainSettings['google_webfonts']);
		$all_fonts = array_merge($google_webfonts, $all_fonts);
		asort($all_fonts);
		return $all_fonts;
		
	}
	
	public function getproductOptions($productId) {
		if($productId != '') {
			$customizeData = $this->_customizeDataRsrce->getCustomizeDataByProductId($productId);
			if(count($customizeData->getData())) {
				$returnData = $customizeData->getData()[0];
				$returnData['is_customize_product'] = $returnData['_customize_product'];
				$returnData['cpd_products'] = unserialize($returnData['cpd_products']);
				$returnData['cpd_product_categories'] = unserialize($returnData['cpd_product_categories']);
				$returnData['cpd_product_settings'] = json_decode(html_entity_decode(stripslashes($returnData['cpd_product_settings'])), true);
				$this->_productsettingsData = $returnData;
				return $returnData;
				//return $this->_productCustomizeOption[$productId] = $returnData;
			}
		}
	}
	public function getmainSettings($key='') {
		
		if($key == '') {
			if($this->_debug) {
				//echo "<br>no key -- return main";
			}
			return $this->_mainsettingsDataRsrce;
		} else {
			if($this->_debug) {
				//echo "<br>key -- return main --".$key;
			}
			if(isset($this->_mainsettingsDataRsrce[$key]) && $this->_mainsettingsDataRsrce[$key]!='') {
				return $this->_mainsettingsDataRsrce[$key];
			}
		}
		return '0';
	}
	
	
	public function getproductSettings($key='') {		
		//echo "<pre>";
		//print_r($this->_productsettingsData); exit;
		if (isset($this->_productsettingsData['cpd_product_settings'])) {
			if($key == '') {
				if($this->_debug) {
					//echo "<br>no key -- return product";
				}
				return $this->_productsettingsData;
			} else {
				if(isset($this->_productsettingsData['cpd_product_settings'][$key]) && is_array($this->_productsettingsData['cpd_product_settings'][$key])) {
					if($this->_debug) {
						//echo "<br>key -- return product array---".$key;
					}
					return implode('", "', $this->_productsettingsData['cpd_product_settings'][$key]);
				} else if(isset($this->_productsettingsData['cpd_product_settings'][$key])){
					if(isset($this->_productsettingsData['cpd_product_settings'][$key])) {
						if($this->_productsettingsData['cpd_product_settings'][$key] != '') {
							if($this->_debug) {
								//echo "<br>key -- return product---".$key;
							}
							return $this->_productsettingsData['cpd_product_settings'][$key];
						} else {
							return $this->getmainSettings($key);
						}
					}
				} else {
					return $this->getmainSettings($key);
				}				
			}
		} else {
			return $this->getmainSettings($key);
		}
		return '';
		
	}
	
	public function getContentIds()
    {
        $getProductDta = $this->_productsettingsData;

        if ($getProductDta) {
            $source_type = $getProductDta['cpd_source_type'];

            $result = '';
            if (empty($source_type) || $source_type == 'category') {
                $result = $getProductDta['cpd_product_categories'];
            } else {
                $result = $getProductDta['cpd_products'];
            }
            return  $result;
        }
    }
	
	public function cpdConvertObjStringToArray($string) {
		
		return json_decode(html_entity_decode(stripslashes($string)), true);
		
	}
	
	public function getProductHtml($productId) {
		
		$prodViews = $this->_customizeProdviewRsrce->getProductHtml($productId);
		$views_data = $prodViews->getData();
		
		$product_html = array();
        if (!empty($views_data)) {
            $first_view = $views_data[0];
			
			$pOptions = $this->_customizeProdRsrce->getOptions($productId)->getData();
			
			$product_options = array('stage_width' => $pOptions[0]['customize_product_width'], 'stage_height' => $pOptions[0]['customize_product_height']);
			
            $first_view['options'] = array(
							'designs_parameter_price' => $first_view['image_price'],
							'custom_texts_parameter_price' => $first_view['text_price'],
							'disable_image_upload' => $first_view['disable_image_upload'],
							'disable_custom_text' => $first_view['disable_custom_text'],
							'disable_facebook' => $first_view['disable_facebook'],
							'disable_instagram' => $first_view['disable_instagram'],
							'disable_designs' => $first_view['disable_designs']
						);		
			
			$view_options = $first_view['options'];

            $view_options = array_merge((array) $product_options, (array) $view_options);
            $view_options = $this->optionsToString($view_options);

            $first_view['view_options'] = $view_options;
			$first_view['anchors_view'] = $this->getElementAnchorsFromView($first_view['elements']);

            $product_html[] = $first_view;

            //sub views
            if (sizeof($views_data) > 1) {
                for ($i = 1; $i <  sizeof($views_data); $i++) {
                    $sub_view = $views_data[$i];

                    $sub_view['options'] = array(
							'designs_parameter_price' => $sub_view['image_price'],
							'custom_texts_parameter_price' => $sub_view['text_price'],
							'disable_image_upload' => $sub_view['disable_image_upload'],
							'disable_custom_text' => $sub_view['disable_custom_text'],
							'disable_facebook' => $sub_view['disable_facebook'],
							'disable_instagram' => $sub_view['disable_instagram'],
							'disable_designs' => $sub_view['disable_designs']
						);		
			
					$view_options = $sub_view['options'];
			
                    $view_options = array_merge((array) $product_options, (array) $view_options);
                    $view_options = $this->optionsToString($view_options);

                    $sub_view['view_options'] = $view_options;
                    $sub_view['anchors_view'] = $this->getElementAnchorsFromView($sub_view['elements']);
                    $product_html[] = $sub_view;
                }
            }
        }
        return $product_html;
	}
	
	public function getElementAnchorsFromView($elements)
    {
        //unserialize when necessary
        if (@unserialize($elements) !== false) {
            $elements = unserialize($elements);
        }
        $view_html = array();
        if (is_array($elements)) {
            foreach ($elements as $element) {
                $element = (array) $element;
                $element['parameters'] = $this->convertParametersToString(
                    $element['parameters'],
                    $element['type']
                );
                if ($element['type'] != 'image') {
                    $element['source'] = stripslashes($element['source']);
                }
                $view_html[] = $element;
            }
        }
        return $view_html;
    }
	
	public function cpdNotEmpty($value)
	{
		$value = gettype($value) === 'string' ? trim($value) : $value;
		return $value == '0' || !empty($value);
	}
	
	public function convertParametersToString($parameters, $type = '')
	{
		if (empty($parameters)) {
			return '{}';
		}

		$params_object = '{';
		foreach ($parameters as $key => $value) {
			if ($this->cpdNotEmpty($value)) {
				//convert boolean value to integer
				if (is_bool($value)) {
					$value = (int) $value;
				}

				switch($key) {
					case 'x':
						$params_object .= '"x":'. $value .',';
						break;
					case 'originX':
						$params_object .= '"originX":"'. $value .'",';
						break;
					case 'y':
						$params_object .= '"y":'. $value .',';
						break;
					case 'z':
						$params_object .= '"z":'. $value .',';
						break;
					case 'colors':
						$params_object .= '"colors":"'. (is_array($value) ? implode(", ", $value) : $value) .'",';
						break;
					case 'removable':
						$params_object .= '"removable":'. $value .',';
						break;
					case 'draggable':
						$params_object .= '"draggable":'. $value .',';
						break;
					case 'rotatable':
						$params_object .= '"rotatable":'. $value .',';
						break;
					case 'resizable':
						$params_object .= '"resizable":'. $value .',';
						break;
					case 'removable':
						$params_object .= '"removable":'. $value .',';
						break;
					case 'zChangeable':
						$params_object .= '"zChangeable":'. $value .',';
						break;
					case 'scale':
						$params_object .= '"scale":'. $value .',';
						break;
					case 'angle':
						$params_object .= '"degree":'. $value .',';
						break;
					case 'price':
						$params_object .= '"price":'. $value .',';
						break;
					case 'autoCenter':
						$params_object .= '"autoCenter":'. $value .',';
						break;
					case 'replace':
						$params_object .= '"replace":"'. $value .'",';
						break;
					case 'autoSelect':
						$params_object .= '"autoSelect":'. $value .',';
						break;
					case 'topped':
						$params_object .= '"topped":'. $value .',';
						break;
					case 'boundingBoxClipping':
						$params_object .= '"boundingBoxClipping":'. $value .',';
						break;
					case 'opacity':
						$params_object .= '"opacity":'. $value .',';
						break;
					case 'minW':
						$params_object .= '"minW":'. $value .',';
						break;
					case 'minH':
						$params_object .= '"minH":'. $value .',';
						break;
					case 'maxW':
						$params_object .= '"maxW":'. $value .',';
						break;
					case 'maxH':
						$params_object .= '"maxH":'. $value .',';
						break;
					case 'resizeToW':
						$params_object .= '"resizeToW":'. $value .',';
						break;
					case 'resizeToH':
						$params_object .= '"resizeToH":'. $value .',';
						break;
					case 'currentColor':
						$params_object .= '"currentColor":"'. $value .'",';
						break;
					case 'uploadZone':
						$params_object .= '"uploadZone":'. $value .',';
						break;
					case 'filters':
						$params_object .= '"filters":['. $value .'],';
						break;
					case 'filter':
						$params_object .= '"filter":'. $value .',';
						break;
				}

				if ($type == 'text') {
					switch($key) {
						case 'font':
							$params_object .= '"font":"'. $value .'",';
							break;
						case 'patternable':
							$params_object .= '"patternable":'. $value .',';
							break;
						case 'textSize':
							$params_object .= '"textSize":'. $value .',';
							break;
						case 'editable':
							$params_object .= '"editable":'. $value .',';
							break;
						case 'lineHeight':
							$params_object .= '"lineHeight":'. $value .',';
							break;
						case 'textDecoration':
							$params_object .= '"textDecoration":"'. $value .'",';
							break;
						case 'maxLength':
							$params_object .= '"maxLength":'. $value .',';
							break;
						case 'fontWeight':
							$params_object .= '"fontWeight":"'. $value .'",';
							break;
						case 'fontStyle':
							$params_object .= '"fontStyle":"'. $value .'",';
							break;
						case 'textAlign':
							$params_object .= '"textAlign":"'. $value .'",';
							break;
						case 'curvable':
							$params_object .= '"curvable":'. $value .',';
							break;
						case 'curved':
							$params_object .= '"curved":'. $value .',';
							break;
						case 'curveSpacing':
							$params_object .= '"curveSpacing":'. $value .',';
							break;
						case 'curveRadius':
							$params_object .= '"curveRadius":'. $value .',';
							break;
						case 'curveReverse':
							$params_object .= '"curveReverse":'. $value .',';
							break;
					}
				}
			}
		}

		if (isset($parameters['uploadZone'])) {
			$params_object .= '"customAdds": {';
			if (isset($parameters['adds_uploads'])) {
				$params_object .= '"uploads":'.$parameters['adds_uploads'].',';
			}
			if (isset($parameters['adds_texts'])) {
				$params_object .= '"texts":'.$parameters['adds_texts'].',';
			}
			if (isset($parameters['adds_designs'])) {
				$params_object .= '"designs":'.$parameters['adds_designs'].',';
			}
			if (isset($parameters['adds_facebook'])) {
				$params_object .= '"facebook":'.$parameters['adds_facebook'].',';
			}
			if (isset($parameters['adds_instagram'])) {
				$params_object .= '"instagram":'.$parameters['adds_instagram'].',';
			}

			$params_object = trim($params_object, ',');
			$params_object .= '},';
		}

		//bounding box
		if (empty($parameters['bounding_box_control'])) {

			//use custom bounding box
			if (isset($parameters['bounding_box_x']) &&
			   isset($parameters['bounding_box_y']) &&
			   isset($parameters['bounding_box_width']) &&
			   isset($parameters['bounding_box_height'])
			   ) {

				if ($this->cpdNotEmpty($parameters['bounding_box_x']) &&
					$this->cpdNotEmpty($parameters['bounding_box_y']) &&
					$this->cpdNotEmpty($parameters['bounding_box_width']) &&
					$this->cpdNotEmpty($parameters['bounding_box_height'])) {
					$params_object .= '"boundingBox": { "x":'. $parameters['bounding_box_x'] .', "y":
					'. $parameters['bounding_box_y'] .', "width":'. $parameters['bounding_box_width'] .
					', "height":'. $parameters['bounding_box_height'] .'}';
				}
			}

		} elseif (isset($parameters['bounding_box_by_other']) &&
			$this->cpdNotEmpty(trim($parameters['bounding_box_by_other']))) {
			$params_object .= '"boundingBox": "'. $parameters['bounding_box_by_other'] .'"';
		}

		$params_object = trim($params_object, ',');
		$params_object .= '}';
		$params_object = str_replace('_', ' ', $params_object);
		return $params_object;
	}
	
	public static function optionsToString($options)
    {

        if (empty($options)) {
            return '{}';
        }

        $params_object = '{';
        foreach ($options as $key => $value) {

            $value = gettype($value) === 'string' ? trim($value) : $value;

            if ($value == '0' || !empty($value)) {

                //convert boolean value to integer
                if (is_bool($value)) {
                    $value = (int) $value;
                }

                switch($key) {
                    case 'stage_width':
                        $params_object .= '"width":'. $value .',';
                        break;
                    case 'stage_height':
                        $params_object .= '"stageHeight":'. $value .',';
                        break;
                    case 'designs_parameter_price':
                        $params_object .= '"customImageParameters": {"price": '. $value .'},';
                        break;
                    case 'custom_texts_parameter_price':
                        $params_object .= '"customTextParameters": {"price": '. $value .'},';
                        break;
                }
            }
        }
		
        $params_object .= '"customAdds": {';

        if (isset($options['disable_image_upload'])) {
            $params_object .= '"uploads": false,';
        }

        if (isset($options['disable_custom_text'])) {
            $params_object .= '"texts": false,';
        }

        if (isset($options['disable_facebook'])) {
            $params_object .= '"facebook": false,';
        }

        if (isset($options['disable_instagram'])) {
            $params_object .= '"instagram": false,';
        }

        if (isset($options['disable_designs'])) {
            $params_object .= '"designs": false,';
        }

        $params_object = trim($params_object, ',');
        $params_object .= '}}';
        $params_object = str_replace('_', ' ', $params_object);

        return $params_object;

    }
	
	public function getImageParametersString() {
		
		return $this->convertParametersToString($this->getImageParameters());
		
	}
	
	public function getImageParameters()
    {
		$images_parameters['x'] = $this->getproductSettings('designs_parameter_x');
        $images_parameters['y'] = $this->getproductSettings('designs_parameter_y');
        $images_parameters['z'] = $this->getproductSettings('designs_parameter_z');
		$images_parameters['colors'] = $this->getproductSettings('designs_parameter_colors');
        $images_parameters['price'] = $this->getproductSettings('designs_parameter_price');
		$images_parameters['autoCenter'] = $this->getproductSettings('designs_parameter_autoCenter');
        $images_parameters['draggable'] = $this->getproductSettings('designs_parameter_draggable');
        $images_parameters['rotatable'] = $this->getproductSettings('designs_parameter_rotatable');
        $images_parameters['resizable'] = $this->getproductSettings('designs_parameter_resizable');
        $images_parameters['zChangeable'] = $this->getproductSettings('designs_parameter_zChangeable');
        $images_parameters['replace'] = $this->getproductSettings('designs_parameter_replace');
        $images_parameters['autoSelect'] = $this->getproductSettings('designs_parameter_autoSelect');
        $images_parameters['topped'] = $this->getproductSettings('designs_parameter_topped');
        $images_parameters['boundingBoxClipping'] = $this->getproductSettings('designs_parameter_boundingBoxClipping');
        $images_parameters['boundingBox'] = $this->getproductSettings('designs_parameter_bounding_box_by_other');

        $images_parameters['filters'] = $this->getproductSettings('designs_parameter_filters');
        $images_parameters['removable'] = 1;
		
		return $images_parameters;
		
    }
	
	public function getCustomImageParametersString()
    {
        $cimages_parameters['minW'] = $this->getproductSettings('uploaded_designs_parameter_minW');
        $cimages_parameters['minH'] = $this->getproductSettings('uploaded_designs_parameter_minH');
        $cimages_parameters['maxW'] = $this->getproductSettings('uploaded_designs_parameter_maxW');
        $cimages_parameters['maxH'] = $this->getproductSettings('uploaded_designs_parameter_maxH');
        $cimages_parameters['resizeToW'] = $this->getproductSettings('uploaded_designs_parameter_resizeToW');
        $cimages_parameters['resizeToH'] = $this->getproductSettings('uploaded_designs_parameter_resizeToH');
		
        return $this->convertParametersToString($cimages_parameters);
    }
	public function getCustomTextParametersString()
    {
        $ctext_parameters['x'] = $this->getproductSettings('custom_texts_parameter_x');
        $ctext_parameters['y'] = $this->getproductSettings('custom_texts_parameter_y');
        $ctext_parameters['z'] = $this->getproductSettings('custom_texts_parameter_z');
        $ctext_parameters['autoCenter'] = $this->getproductSettings('custom_texts_parameter_autoCenter');
        $ctext_parameters['draggable'] = $this->getproductSettings('custom_texts_parameter_draggable');
        $ctext_parameters['rotatable'] = $this->getproductSettings('custom_texts_parameter_rotatable');
        $ctext_parameters['resizable'] = $this->getproductSettings('custom_texts_parameter_resizable');
        $ctext_parameters['zChangeable'] = $this->getproductSettings('custom_texts_parameter_zChangeable');
        $ctext_parameters['replace'] = $this->getproductSettings('custom_texts_parameter_replace');
        $ctext_parameters['autoSelect'] = $this->getproductSettings('custom_texts_parameter_autoSelect');
        $ctext_parameters['topped'] = $this->getproductSettings('custom_texts_parameter_topped');
        $ctext_parameters['patternable'] = $this->getproductSettings('custom_texts_parameter_patternable');
        $ctext_parameters['curvable'] = $this->getproductSettings('custom_texts_parameter_curvable');
        $ctext_parameters['curveSpacing'] = $this->getproductSettings('custom_texts_parameter_curveSpacing');
        $ctext_parameters['curveRadius'] = $this->getproductSettings('custom_texts_parameter_curveRadius');
        $ctext_parameters['curveReverse'] = $this->getproductSettings('custom_texts_parameter_curveReverse');
        $ctext_parameters['boundingBoxClipping'] = $this->getproductSettings('custom_texts_parameter_boundingBoxClipping');
        $ctext_parameters['boundingBox'] = $this->getproductSettings('custom_texts_parameter_bounding_box_by_other');
        $ctext_parameters['textSize'] = $this->getproductSettings('custom_texts_parameter_textSize');
        $ctext_parameters['maxLength'] = $this->getproductSettings('custom_texts_parameter_maxLength');
        $ctext_parameters['textAlign'] = $this->getproductSettings('custom_texts_parameter_textAlign');
        $ctext_parameters['colors'] = $this->getproductSettings('custom_texts_parameter_colors');
        $ctext_parameters['price'] = $this->getproductSettings('custom_texts_parameter_price');
		$ctext_parameters['removable'] = 1;
        return $this->convertParametersToString($ctext_parameters);
    }
	
	public function getmarginValues() {
		
		$marginArray['Top'] = $this->getmainSettings('Top');
		$marginArray['Right'] = $this->getmainSettings('Right');
		$marginArray['Bottom'] = $this->getmainSettings('Bottom');
		$marginArray['Left'] = $this->getmainSettings('Left');
		return $marginArray;
		//return http_build_query($marginArray);
		
	}
	public function getStoreUrl($type='site', $value=''){

		if($type=='site') {
			$url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);
		} else {	
			$url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		}
		if($value!='') {
			return $url . $value;
		}
		return $url;
	}
	
	private function getPatternUrls()
    {
        $urls = array();
        $path =  BP . '/app/code/Chilliapple/Customizeproducts/view/base/web/img/patterns/';

        if (file_exists($path)) {
            $folder = opendir($path);
            $pic_types = array("jpg", "jpeg", "png");
			$image_url = $this->_assetRepo->getUrl("Chilliapple_Customizeproducts::img/patterns/");
            while ($file = readdir($folder)) {
                if (in_array(substr(strtolower($file), strrpos($file, ".") + 1), $pic_types)) {
                    $urls[] = '"'.$image_url."/".$file.'"';
                }
            }
            closedir($folder);
        }
        return $urls;
    }
	
	public function getLabels()
    {
        $labels = array();
        $labels['layersButton'] = __('Manage Layers');
        $labels['addsButton'] = __('Add');
        $labels['productsButton'] = __('Change Products');
        $labels['moreButton'] = __('Actions');
        $labels['downLoadPDF'] = __('Download PDF');
        $labels['downloadImage'] = __('Download Image');
        $labels['print'] = __('Print');
        $labels['saveProduct'] = __('Save');
        $labels['loadProduct'] = __('Load');
        $labels['undoButton'] = __('Undo');
        $labels['redoButton'] = __('Redo');
        $labels['resetProductButton'] = __('Reset Product');
        $labels['zoomButton'] = __('Zoom');
        $labels['panButton'] = __('Pan');
        $labels['addImageButton'] = __('Add your own Image');
        $labels['addTextButton'] = __('Add your own text');
        $labels['enterText'] = __('Enter your text');
        $labels['addFBButton'] = __('Add photo from facebook');
        $labels['addInstaButton'] = __('Add photo from instagram');
        $labels['addDesignButton'] = __('Choose from Designs');
        $labels['editElement'] = __('Edit Element');
        $labels['fillOptions'] = __('Fill Options');
        $labels['color'] = __('Color');
        $labels['patterns'] = __('Patterns');
        $labels['opacity'] = __('Opacity');
        $labels['filter'] = __('Filter');
        $labels['textOptions'] = __('Text Options');
        $labels['changeText'] = __('Change Text');
        $labels['typeface'] = __('Typeface');
        $labels['lineHeight'] = __('Line Height');
        $labels['textAlign'] = __('Alignment');
        $labels['textAlignLeft'] = __('Align Left');
        $labels['textAlignCenter'] = __('Align Center');
        $labels['textAlignRight'] = __('Align Right');
        $labels['textStyling'] = __('Styling');
        $labels['bold'] = __('Bold');
        $labels['italic'] = __('Italic');
        $labels['underline'] = __('Underline');
        $labels['curvedText'] = __('Curved Text');
        $labels['curvedTextSpacing'] = __('Spacing');
        $labels['curvedTextRadius'] = __('Radius');
        $labels['curvedTextReverse'] = __('Reverse');
        $labels['transform'] = __('Transform');
        $labels['angle'] = __('Angle');
        $labels['scale'] = __('Scale');
        $labels['moveUp'] = __('Move Up');
        $labels['moveDown'] = __('Move Down');
        $labels['centerH'] = __('Center Horizontal');
        $labels['centerV'] = __('Center Vertical');
        $labels['flipHorizontal'] = __('Flip Horizontal');
        $labels['flipVertical'] = __('Flip Vertical');
        $labels['resetElement'] = __('Reset Element');
        $labels['fbSelectAlbum'] = __('Select an album');
        $labels['instaFeedButton'] = __('My Feed');
        $labels['instaRecentImagesButton'] = __('My Recent Images');
        $labels['productSaved'] = __('Product Saved!');
        $labels['lock'] = __('Lock');
        $labels['unlock'] = __('Unlock');
        $labels['remove'] = __('Remove');
        $labels['outOfContainmentAlert'] = __('Move it in his containment!');
        $labels['initText'] = __('Initializing product designer');
        $labels['myUploadedImgCat'] = __('Your uploaded images');
        $labels['uploadedDesignSizeAlert'] = __(
            'Sorry! The image you have uploaded does not meet the size requirements.'
            . ' Minimum Width: 10 pixels, Minimum Height: 10 pixels, '
            . 'Maximum Width: 199 pixels, Maximum Height: 199 pixels'
        );
        $labels['modalSubmit'] = __('OK, got it!');

        $obj_string = '{';
        foreach ($labels as $key => $value) {
            $obj_string .= $key.':"'.$value.'",';
        }
        $obj_string = rtrim($obj_string, ",");
        $obj_string .= '}';
        return $obj_string;
    }
	
	public function getcategoryHtml($custom_content_id) {
		
		if($custom_content_id) {
				
			$categoryData = $this->_prodCategoryRsrce->load($custom_content_id);
			
			return $categoryData->getData();
		
		}
	}
	
	public function getproductpageData($icc = 0) {
	
		if($this->_debug) {
			//echo "<pre>";
			//print_r($this->getproductSettings());
			//print_r($this->getmainSettings());
		}
		
		if ($this->getproductSettings('font_families') == '') {
			$allfonts = $this->getEnabledFonts();
		} else {
			$allfonts =  $this->getproductSettings('font_families');
		}
		
		if (!is_array($allfonts)) {
			$len = strlen($allfonts);
			$allfonts = str_split($allfonts, $len);
		}

		if (is_array($allfonts) && !empty($allfonts)) {
			$jsfonts = implode('", "', $allfonts);
		} else {
			$jsfonts = '';
		}
		if($this->_debug) {
			//echo "<br>jsfonts---".$jsfonts;
		}
		
		$getProductDta = $this->_productsettingsData;
		$custom_content_ids = $this->getContentIds();
		
		if ($getProductDta) {
			$designs_html = array();
			$source_type = $getProductDta['cpd_source_type'];
			$category_html = '';
			$product_html = array();

			if (is_array($custom_content_ids)) {
				foreach ($custom_content_ids as $custom_content_id) {
					if (empty($source_type) || $source_type == 'category') {
						//$this->_prodCategoryRsrce->load($custom_content_id);
						//$custom_category = new CustomizeProductsCategory($custom_content_id);
						$category_html = $this->getcategoryHtml($custom_content_id);
						$custom_products_data = $this->_customizeProdRsrce->getcategoryProducts($custom_content_id)->getData();
						if($this->_debug) {
							//print_r($custom_products_data);
						}
						foreach ($custom_products_data as $custom_product_data) {
							$product_html[] = self::getProductHtml($custom_product_data['product_id']);
						}
					} else {
						$product_html[] = $this->getProductHtml($custom_content_id);
					}
				}
				if($this->_debug) {
					//print_r($product_html);
					//echo "<br>---------<br>";
				}
				
				//output designs
				$designs = $this->_customDesignRsrce->getCollection()->getData();
				
				if($this->_debug) {
					//print_r($designs);
				}
				
				if (!empty($designs)) {
					$final_parameters =  $this->getImageParameters();
					if($this->_debug) {
						//print_r($final_parameters);
					}
					if (is_array($designs)) {
						$di = 0;
						foreach ($designs as $design) {
							//single element parameters
							if (isset($design['enabled']) && $design['enabled']) {
								//uncertain array positions
								$final_parameters = array_merge($final_parameters, $design);
								//$final_parameters = array_merge($design, $final_parameters);
							}
							//convert array to string
							$design_parameters_str = $this->convertParametersToString($final_parameters);
							$origin_image = $design['design_image'];
							
							if ($origin_image) {
								$designs_html[$di]['origin_image'] = $origin_image;
								$designs_html[$di]['parameters'] = $design_parameters_str;
								$di++;
							}
						}
					}
				}
			}
			if($this->_debug) {
				//print_r($final_parameters);
				//print_r($designs_html);
			}
			$view_selection_floated = $this->getproductSettings('view_selection_floated');
			$view_selection_floated = $view_selection_floated ? $view_selection_floated : 0;
			$open_in_lightbox = $this->getproductSettings('open_in_lightbox');
			$modal_box_css = $open_in_lightbox ? ' fpd-lightbox-enabled' : '';

			$stage_width = $this->getproductSettings('stage_width');
			
			//define the designer margins
			$designer_margins = $this->getmarginValues();
			$margin_styles = '';
			
			if (!empty($designer_margins)) {
				foreach ($designer_margins as $margin_key => $margin_val) {
					$margin_styles .= 'margin-'.strtolower($margin_key).':'.$margin_val.'px;';
				}
			}
						
			$stage_height = $this->getproductSettings('stage_height');

			//if ($this->getproductSettings('hide_custom_image_upload') != '' && $this->getproductSettings('hide_custom_image_upload') != 0) {
			if ($this->getproductSettings('hide_custom_image_upload') == 1) {
				//$hciu = $this->getproductSettings('hide_custom_image_upload');
				$hciu = 0;
			} else {
				$hciu =  (int)$this->getmainSettings('upload_designs');
			}
			$hide_custom_image_upload = $hciu;

			//if ($this->getproductSettings('hide_custom_text') != '' && $this->getproductSettings('hide_custom_text') != 0) {
			if ($this->getproductSettings('hide_custom_text') == 1) {
				//$hct = $this->getproductSettings('hide_custom_text');
				$hct = 0;
			} else {
				$hct =  (int)$this->getmainSettings('custom_texts');
			}
			$hide_custom_text = $hct;

			//if ($this->getproductSettings('hide_facebook_tab') != '' && $this->getproductSettings('hide_facebook_tab') != 0) {
			if ($this->getproductSettings('hide_facebook_tab') == 1) {
				//$hide_facebook_tab = $this->getproductSettings('hide_facebook_tab');
				$hide_facebook_tab = 0;
			} else {
				$hide_facebook_tab =  $this->getmainSettings('facebook_tab');
			}
			
			//if ($this->getproductSettings('hide_instagram_tab') != '' && $this->getproductSettings('hide_instagram_tab') != 0) {
			if ($this->getproductSettings('hide_instagram_tab') == 1) {
				//$hide_instagram_tab = $this->getproductSettings('hide_instagram_tab');
				$hide_instagram_tab = 0;
			} else {
				$hide_instagram_tab =  $this->getmainSettings('instagram_tab');
			}
			$base_uri = $this->getStoreUrl();
						
			$admin_ajax = $base_uri.'customizeproducts/designer/ajax/';
			$image_dta_url = $base_uri.'customizeproducts/designer/getimagedataurl/';
			$template_dir = $base_uri.'customizeproducts/designer/productdesigner/';
			$phpDirectory = $base_uri.'customizeproducts/designer/';
			$instagram_redirect_uri = $base_uri.'customizeproducts/designer/instagramauth/';
			
			$getImageparams = $this->getImageParametersString();
			$getCustomImageparams = $this->getCustomImageParametersString();
			$getCustomTextparams = $this->getCustomTextParametersString();
			$patterns = implode(',', $this->getPatternUrls());
			
			$get_form_views = ''; //Set back form views

			if ($icc) {
				$fpd_product = $this->_customizeCartdataRsrce->getCustomizedcartdata(array($icc));
				if(isset($fpd_product[0])) {
					$get_form_views = $fpd_product[0]['data'];
				}
			}

			$shadow = $this->getproductSettings('frame_shadow');
			
			$replaceInitialElements = $this->getproductSettings('replace_initial_elements');
			
			$dialog_box_positioning = $this->getproductSettings('dialog_box_positioning');
			
			$change_product_image = $this->getproductSettings('change_product_image');
			
			$change_product_image = $change_product_image ? $change_product_image : 0;
			
			$labels = $this->getLabels();
			
			if($this->_debug) {
				/*echo "<br>view_selection_floated--".$view_selection_floated;
				echo "<br>open_in_lightbox--".$open_in_lightbox;
				echo "<br>modal_box_css--".$modal_box_css;
				echo "<br>stage_width--".$stage_width;
				echo "<br>margin_styles--".$margin_styles;
				echo "<br>stage_height--".$stage_height;
				echo "<br>hide_custom_image_upload--".$hide_custom_image_upload;
				echo "<br>hide_custom_text--".$hide_custom_text;
				echo "<br>hide_facebook_tab--".$hide_facebook_tab;
				echo "<br>hide_instagram_tab--".$hide_instagram_tab;
				echo "<br>base_uri--".$base_uri;
				echo "<br>getCustomImageparams--".$getCustomImageparams;
				echo "<br>getCustomTextparams--".$getCustomTextparams;
				print_r($patterns);
				echo "<br>shadow--".$shadow;
				echo "<br>replaceInitialElements--".$replaceInitialElements;
				echo "<br>dialog_box_positioning--".$dialog_box_positioning;
				echo "<br>change_product_image--".$change_product_image;
				echo "<br>labels=---".$labels;
				echo "</pre>";*/
			}
			return array(
				'source_type' => $source_type,
				'category_html' => $category_html,
				'product_html' => $product_html,
				'designs_html' => $designs_html,
				'icc' => $icc,
				'available_fonts' => $allfonts,
				'getProductDta' => $getProductDta,
				'custom_content_ids' => $custom_content_ids,
				'stage_width' => $stage_width,
				'stage_height' => $stage_height,
				'admin_ajax' => $admin_ajax,
				'getImageparams' => $getImageparams,
				'getCustomImageparams' => $getCustomImageparams,
				'image_dta_url' => $image_dta_url,
				'template_dir' => $template_dir,
				'instagram_redirect_uri' => $instagram_redirect_uri,
				'phpDirectory' => $phpDirectory,
				'getCustomTextparams' => $getCustomTextparams,
				'jsfonts' => $jsfonts,
				'hide_custom_image_upload' => $hide_custom_image_upload,
				'hide_custom_text' => $hide_custom_text,
				'hide_facebook_tab' => $hide_facebook_tab,
				'hide_instagram_tab' => $hide_instagram_tab,
				'get_form_views' => $get_form_views,
				'open_in_lightbox' => $open_in_lightbox,
				'modal_box_css' => $modal_box_css,
				'view_selection_floated' => $view_selection_floated,
				'shadow' => $shadow,
				'replaceInitialElements' => $replaceInitialElements,
				'dialog_box_positioning' => $dialog_box_positioning,
				'patterns' => $patterns,
				'change_product_image' => $change_product_image,
				'labels' => $labels,
				'margin_styles' => $margin_styles,
				'currency_symbol' => $this->_storeManager->getStore()->getCurrentCurrency()->getCurrencySymbol(),
				'base_uri' => $base_uri
			);
		}
		
	}
}