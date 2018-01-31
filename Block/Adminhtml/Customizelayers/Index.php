<?php
/**
 * Copyright © 2015 Chilliapple . All rights reserved.
 */
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizelayers;

class Index extends \Magento\Backend\Block\Template
{
	protected $_customizeProdcount = 0;
	
	protected $_customizeProdid = null;
	
	protected $_customizeStagewidth = 0;
	
	protected $_customizeStageheight = 0;
	
	protected $_modelProd;
	
	protected $_mainSettings = array();
	
	public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [], \Chilliapple\Customizeproducts\Model\Customizeprod $prodModel)
    {
		$this->_modelProd = $prodModel;
		$prodCollection = $this->_modelProd->getCollection();
		$this->_customizeProdcount = $prodCollection->count();
		$this->setmainSettings();		
		parent::__construct($context, $data);
    }
	
	public function getProductId() {
		return $this->_customizeProdid;
	}
	
	public function getProductCount() {
		return $this->_customizeProdcount;
	}
	
	public function getProductViews() {
		$returnArray = array();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$viewsModel = $objectManager->create('Chilliapple\Customizeproducts\Model\Customizeprodview');
		$collection = $viewsModel->getCollection();
		$collection->getSelect()->joinLeft(
		['customizeprod'=>$collection->getTable('customizeproducts_customizeprod')],
		'main_table.product_id = customizeprod.id',
		['product_name'=>'customizeprod.title']);
		$collection->getSelect()->order('customizeprod.title', 'ASC');
		foreach($collection as $data) {
			$returnArray[$data['product_id']]['label'] = $data['product_name'];
			$returnArray[$data['product_id']]['value'][] = array('id' => $data['id'], 'title' => $data['title']);
		}
		return $returnArray;
	}
	
	public function getdefaultLayerId() {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$viewsModel = $objectManager->create('Chilliapple\Customizeproducts\Model\Customizeprodview');
		$collection = $viewsModel->getCollection();
		$collection->getSelect()->limit(1);
		foreach($collection as $data) {
			return $data['id'];
		}
	}
	
	public function getLayerid() {
		
		$layerId = "";
		$layerId = $this->getRequest()->getParam('view_id');
		
		if(!$layerId)
			$layerId = $this->getdefaultLayerId();
		
		return $layerId;
		
	}
	
	public function renderOptions($layerId) {
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$viewsModel = $objectManager->create('Chilliapple\Customizeproducts\Model\Customizeprodview');
		$layerData = $viewsModel->load($layerId);
		$requested_view_elements = unserialize($layerData->getData('elements'));
		$htmllist = '';
		$index = 0;
		$this->_customizeProdid = $layerData['product_id'];
		
		if($this->_customizeProdid != null) {
			$this->setpanelHeightandWidth($this->_customizeProdid);
		}
		
		if (is_array($requested_view_elements) && !empty($requested_view_elements)) {
            foreach ($requested_view_elements as $view_element) {
                if (isset($view_element['parameters']) && !empty($view_element['parameters'])) {
                    $htmllist .= $this->getElementListItem(
                        $index,
                        $view_element['title'],
                        $view_element['type'],
                        stripslashes($view_element['source']),
                        http_build_query($view_element['parameters'])
                    );
                    $index++;
                }
            }
        }
		return $htmllist;
	}
	
	public function getElementListItem($index, $title, $type, $source, $parameters)
    {
        $change_image_icon = '';
        if ($type == 'image') {
            $change_image_icon = '<a href="#" class="fpd-change-image fpd-admin-tooltip"';
            $change_image_icon .= ' title="'.__("Change Image Source").'">';
            $change_image_icon .= '<i class="fpd-admin-icon-repeat"></i></a>';
            $element_identifier = '<img src="'.$source.'" />';
        } else {
            $element_identifier = '<i class="fpd-admin-icon-text-format"></i>';
        }
        $lock_icon = 'fpd-admin-icon-lock-open';

        if (strpos($parameters, 'locked=1') !== false) {
            $lock_icon = 'fpd-admin-icon-lock';
        }

        $list_html = '<li id="'.$index.'" class="fpd-clearfix"><div><span class="fpd-element-identifier">';
        $list_html .= $element_identifier.'</span><input type="text" name="element_titles[]"';
        $list_html .= ' value="'.($type == 'image' ? $title : $source).'" /></div><div>';
        $list_html .= $change_image_icon.'<a href="#" class="fpd-lock-element"><i class="'.$lock_icon.'"></i></a>';
        $list_html .= '<a href="#" class="fpd-trash-element"><i class="fpd-admin-icon-close"></i></a></div>';
        $list_html .= '<textarea name="element_sources[]">'.$source.'</textarea>';
        $list_html .= '<input type="hidden" name="element_types[]" value="'.$type.'"/>';
        $list_html .= '<input type="hidden" name="element_parameters[]" value="'.$parameters.'"/></li>';
        
		return $list_html;
    }
	
	public function setmainSettings() {
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customsettingsModel = $objectManager->create('Chilliapple\Customizeproducts\Model\Customsettings');
		$customsettingsData = $customsettingsModel->load(1);
		$this->_mainSettings = $customsettingsData->getData();
		
	}
	
	public function getEnabledFonts() {
		$all_fonts = array();
		$common_fonts = explode(",", $this->_mainSettings['common_fonts']);
		$all_fonts = array_merge($common_fonts, $all_fonts);
		$google_webfonts = explode(",", $this->_mainSettings['google_webfonts']);
		$all_fonts = array_merge($google_webfonts, $all_fonts);
		$fonts_directory = explode(",", $this->_mainSettings['fonts_directory']);
		$all_fonts = array_merge($fonts_directory, $all_fonts);
		asort($all_fonts);
		return $all_fonts;
	}
	
	public function setpanelHeightandWidth($prodId) {
		
		$prodData = $this->_modelProd->load($prodId);
		$this->_customizeStagewidth = $prodData->getData('customize_product_width');
		$this->_customizeStageheight = $prodData->getData('customize_product_height');
	}
	
	public function getCanvaswidth() {
		if($this->getProductId() != null) {
			return $this->_customizeStagewidth;
		} else {
			return $this->_mainSettings['stage_width'];
		}
	}
	public function getCanvasheight() {
		if($this->getProductId() != null) {
			return $this->_customizeStageheight;
		} else {
			return $this->_mainSettings['stage_height'];
		}
	}
}
