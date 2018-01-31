<?php
/**
 * My own options
 *
 */
namespace Chilliapple\Customizeproducts\Model\Config\Source;
class Categoryoptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		$pcatCollection = $objectManager->create('Chilliapple\Customizeproducts\Model\ResourceModel\Productcategory\Collection');
		$collection = $pcatCollection->getData();
		
		$returnArray = array();
		foreach($collection as $data) {
			$returnArray[] = array('value'=>$data['id'], 'label'=>$data['title']);
		}
		
		/*return array(
		   array('value'=>array(array('value'=>'1', 'label'=>'one')), 'label'=>'OPTGROUP'),
		   array('value'=>'2', 'label'=>'two')
		);*/
		return $returnArray;
    }
}