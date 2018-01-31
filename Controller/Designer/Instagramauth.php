<?php
namespace Chilliapple\Customizeproducts\Controller\Designer;

use Magento\Framework\App\Action\Context;

class Instagramauth extends \Magento\Framework\App\Action\Action
{
	
	/**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @param Context $context
     * @param \Chilliapple\Customizeproducts\Helper\Data $dataHelper
     */
    public function __construct(Context $context, \Chilliapple\Customizeproducts\Helper\Data $dataHelper)
    {
        $this->_dataHelper = $dataHelper;
        parent::__construct($context);
    }
	
	public function execute()
	{
		//$data = $this->getRequest()->getParams();
		//echo "<pre>";
		//print_r($data);
		//exit;
	}
}