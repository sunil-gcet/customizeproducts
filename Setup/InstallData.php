<?php

namespace Chilliapple\Customizeproducts\Setup;



use Magento\Framework\Module\Setup\Migration;

use Magento\Framework\Setup\InstallDataInterface;

use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Framework\Setup\ModuleDataSetupInterface;



/**

 * @codeCoverageIgnore

 */

class InstallData implements InstallDataInterface

{

	

	/**

     * Post factory

     *

     * @var \Magefan\Blog\Model\PostFactory

     */

    private $_customsettingFactory;



    /**

     * Init

     *

     * @param \Magefan\Blog\Model\PostFactory $postFactory

     */

    public function __construct(\Chilliapple\Customizeproducts\Model\CustomsettingsFactory $customsettingFactory)

    {

        $this->_customsettingFactory = $customsettingFactory;

    }

	

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)

    {

		$setup->getConnection()->query("INSERT INTO customizeproducts_customsettings SET id = '1', stage_width = '600', stage_height = '800'");

    }



}
