<?php
namespace Chilliapple\Customizeproducts\Controller\Designer;

use Magento\Framework\App\Action\Context;

class Ajax extends \Magento\Framework\App\Action\Action
{
	
	/**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $_ajaxHelper;

    /**
     * @param Context $context
     * @param \Chilliapple\Customizeproducts\Helper\Data $ajaxHelper
     */
    public function __construct(Context $context, \Chilliapple\Customizeproducts\Helper\Ajaxfunctions $ajaxHelper)
    {
        $this->_ajaxHelper = $ajaxHelper;
        parent::__construct($context);
    }
	
	public function execute()
	{
		$data = $this->getRequest()->getParams();
		if ($data) {
			$action = trim($data['action']);
			if (isset($action)) {
				switch ($action) {

					case 'fpd_newproduct':
						$results = $this->_ajaxHelper->new_product();
						break;

					case 'fpd_editproduct':
						$results = $this->_ajaxHelper->edit_product();
						break;

					case 'fpd_removeproduct':
						$results = $this->_ajaxHelper->remove_product();
						break;

					case 'fpd_newview':
						$results = $this->_ajaxHelper->new_view();
						break;

					case 'fpd_editview':
						$results = $this->_ajaxHelper->edit_view();
						break;

					case 'fpd_removeview':
						$results = $this->_ajaxHelper->remove_view();
						break;

					case 'fpd_saveviews':
						$results = $this->_ajaxHelper->save_views();
						break;

					case 'fpd_newcategory':
						$results = $this->_ajaxHelper->new_category();
						break;

					case 'fpd_assigncategory':
						$results = $this->_ajaxHelper->assign_category();
						break;

					case 'fpd_removecategory':
						$results = $this->_ajaxHelper->remove_category();
						break;

					case 'fpduploadimage':
						$results = $this->_ajaxHelper->upload_image($data, $this->getRequest()->getFiles());
						break;

					case 'fpd_uploadsocialphoto':
						$results = $this->_ajaxHelper->upload_social_image($data);
						break;

					case 'fpd_loadorder':
						$results = $this->_ajaxHelper->load_order();
						break;

					case 'fpd_loadorderitemimages':
						$results = $this->_ajaxHelper->load_order_item_images();
						break;

					case 'fpd_pdffromdataurl':
						$results = $this->_ajaxHelper->create_pdf_from_dataurl();
						break;

					case 'fpd_imagefromsvg':
						$results = $this->_ajaxHelper->create_image_from_svg();
						break;

					case 'fpd_imagefromdataurl':
						$results = $this->_ajaxHelper->create_image_from_dataurl();
						break;
				}
				$this->getResponse()->setBody($results);
			}		
		}
	}
}