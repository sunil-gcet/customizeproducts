<?php
namespace Chilliapple\Customizeproducts\Block\Adminhtml\Customizeprodview\Renderer;

class Product extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
	public function render(\Magento\Framework\DataObject $row)
    {
        $buttonType = $this->getColumn()->getButtonType();
        $buttonClass = $this->getColumn()->getButtonClass();
		// Get default value:
        $value = parent::_getValue($row);
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		$pproCollection = $objectManager->create('Chilliapple\Customizeproducts\Model\ResourceModel\Customizeprod\Collection');
		$pproCollection->getSelect()->where("main_table.id = '".$value."'");
		$pData = $pproCollection->getData();
		
		foreach($pData as $data) {
			return $data['title'];
		}
    }
}