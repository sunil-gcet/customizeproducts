<?php
/**
 * Copyright © 2015 Chilliapple. All rights reserved.
 */

namespace Chilliapple\Customizeproducts\Model;

use Magento\Framework\Exception\CustomizeprodException;

/**
 * Customizeprodtab customizeprod model
 */
class Customizeprod extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Chilliapple\Customizeproducts\Model\ResourceModel\Customizeprod');
    }
	
	public function create($data) {
		
		$this->setData($data);

        $this->save();
		
		return $this->getId();
		
	}
	
	public function getOptions($productId) {
		
		$collection = $this->getCollection();
        $collection->addFieldToFilter(
            'id',
            (int)$productId
        );
        return $collection;
		
	}
	
	public function getcategoryProducts($catId)
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('customizeproducts_prodtocat');
		
        $collection = $this->getCollection();		
		$collection->getSelect()->joinLeft(
				['cat_table'=> $tableName],
				'main_table.id = cat_table.product_id'
			);
        $collection->addFieldToFilter(
            'cat_table.category_id',
            (int)$catId
        );
        return $collection;
    }
	
	public function getProductItemHtml($id, $title, $category_ids, $options)
    {

        return '<li id="'.$id.'" data-categories="'.$category_ids.'" class="fpd-product-item fpd-clearfix">
					<span>
						<span class="fpd-item-id">#'.$id.' - </span>
						<span class="fpd-product-title">'.$title.'</span>
					</span>
					<span>
						<a href="#" class="fpd-add-view fpd-admin-tooltip" title="'.__('Add View').'">
							<i class="fpd-admin-icon-add-box"></i>
						</a>
						<a href="#" class="fpd-edit-product-title fpd-admin-tooltip" title="
						'.__('Edit Title').'">
							<i class="fpd-admin-icon-mode-edit"></i>
						</a>
						<a href="#" class="fpd-edit-product-options fpd-admin-tooltip" title="
						'.__('Edit Options').'">
							<input type="hidden" class="fpd-product-options fpd-hidden" value="'.$options.'" />
							<i class="fpd-admin-icon-settings"></i>
						</a>
						<a href="#" class="fpd-remove-product fpd-admin-tooltip" title="
						'.__('Remove').'">
							<i class="fpd-admin-icon-close"></i>
						</a>
					</span>
				</li>';

    }
	
	public function getViewItemHtml($id, $image, $title, $options)
    {
        return '<li id="'.$id.'" class="fpd-view-item fpd-clearfix">
                        <span>
                            <img src="'.$image.'"/>
                            <label>'.$title.'</label>
                        </span>
                        <span>
                            <a href="#" class="fpd-edit-view fpd-admin-tooltip" title="'.__('Edit').'">
                                <i class="fpd-admin-icon-mode-edit"></i>
                            </a>
                            <a href="#" class="fpd-edit-view-options fpd-admin-tooltip" title="
                            '.__('Edit Options').'">
                                <input type="hidden" class="fpd-view-options fpd-hidden" value="'.$options.'" />
                                <i class="fpd-admin-icon-settings"></i>
                            </a>
                            <a href="#" class="fpd-remove-view fpd-admin-tooltip" title="'.__('Remove').'">
                                <i class="fpd-admin-icon-close"></i>
                            </a>
                        </span>
                    </li>';

    }
	
}