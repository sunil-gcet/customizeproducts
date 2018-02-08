<?php
namespace Chilliapple\Customizeproducts\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'customizeproducts_customizeprod'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_customizeprod')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_customizeprod'
        )
		->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'title'
        )
		->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			100,
            [],
            'Category Id'
        )
		->addColumn(
            'customize_product_width',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			50,
            ['default' => 900],
            'Customize Product Width'
        )
		->addColumn(
            'customize_product_height',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            50,
            ['default' => 700],
            'Customize Product Height'
        )
		->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Status'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_customizeprod'
        );
		
		$installer->getConnection()->createTable($table);
		
		
		/**
         * Create table 'customizeproducts_productcategory'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_productcategory')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_productcategory'
        )
		->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '255',
            [],
            'Title'
        )
		->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            [],
            'Status'
        )
		/*{{CedAddTableColumn}}}*/
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_productcategory'
        );
		
		$installer->getConnection()->createTable($table);
		
		/**
         * Create table 'customizeproducts_customizeprodview'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_customizeprodview')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_customizeprodview'
        )
		->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '255',
            [],
            'title'
        )
		->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Product Id'
        )
		->addColumn(
            'view_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '255',
            [],
            'View Image'
        )
		->addColumn(
            'image_price',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            ['nullable' => false, 'default' => 0],
            'Image Price'
        )
		->addColumn(
            'text_price',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            ['nullable' => false, 'default' => 0],
            'Text Price'
        )
		->addColumn(
            'disable_image_upload',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['default' => 0],
            'Disable Image Upload'
        )
		->addColumn(
            'disable_custom_text',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['default' => 0],
            'Disable Custom Text'
        )
		->addColumn(
            'disable_facebook',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['default' => 0],
            'Disable Facebook'
        )
		->addColumn(
            'disable_instagram',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['default' => 0],
            'Disable Instagram'
        )
		->addColumn(
            'disable_designs',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['default' => 0],
            'Disable Designs'
        )
		->addColumn(
            'view_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['default' => 0],
            'View Order'
        )
		->addColumn(
            'elements',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Elements'
        )
		/*{{CedAddTableColumn}}}*/
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_customizeprodview'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/
		
		/**
         * Create table 'customizeproducts_customizedesign'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_customizedesign')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_customizedesign'
        )
		->addColumn(
            'design_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'enable_options'
        )
		->addColumn(
            'enabled',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'enable_options'
        )
		->addColumn(
            'x',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            ['nullable' => false],
            'X Pos'
        )
		->addColumn(
            'y',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            ['nullable' => false],
            'Y Pos'
        )
		->addColumn(
            'z',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            ['nullable' => false],
            'Z Pos'
        )
		->addColumn(
            'scale',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            ['nullable' => false],
            'Scale'
        )
		->addColumn(
            'colors',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Colors'
        )
		->addColumn(
            'price',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            10,
            ['nullable' => false],
            'price'
        )
		->addColumn(
            'autoCenter',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Auto Center'
        )
		->addColumn(
            'draggable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Draggable'
        )
		->addColumn(
            'rotatable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Rotatable'
        )
		->addColumn(
            'resizable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Resizable'
        )
		/*{{CedAddTableColumn}}}*/		
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_customizedesign'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/
		
		/**
         * Create table 'customizeproducts_customsettings'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_customsettings')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_customsettings'
        )
		->addColumn(
            'stage_width',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Stage Width'
        )
		->addColumn(
            'stage_height',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Stage Height'
        )
		->addColumn(
            'frame_shadow',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            20,
            ['nullable' => false],
            'Frame Shadow'
        )
		->addColumn(
            'dialog_box_positioning',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            20,
            ['nullable' => false],
            'Dialog Box Positioning'
        )
		->addColumn(
            'view_selection_position',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            20,
            ['nullable' => false],
            'View Selection Position'
        )
		->addColumn(
            'Top',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Top'
        )
		->addColumn(
            'Right',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Right'
        )
		->addColumn(
            'Bottom',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Bottom'
        )
		->addColumn(
            'Left',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Left'
        )
		->addColumn(
            'display_customizable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Display Customizable'
        )
		->addColumn(
            'designer_primary_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designer Primary Color'
        )
		->addColumn(
            'designer_secondary_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designer Secondary Color'
        )
		->addColumn(
            'designer_primary_text_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designer Primary Text Color'
        )
		->addColumn(
            'designer_secondary_text_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designer Secondary Text Color'
        )
		->addColumn(
            'selected_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Selected Color'
        )
		->addColumn(
            'bounding_box_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Bounding Box Color'
        )
		->addColumn(
            'out_of_boundary_color',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'out_of_boundary_color'
        )
		->addColumn(
            'upload_designs',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Upload Designs'
        )
		->addColumn(
            'facebook_tab',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Facebook Tab'
        )
		->addColumn(
            'instagram_tab',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Instagram Tab'
        )
		->addColumn(
            'custom_texts',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Custom Texts'
        )
		->addColumn(
            'download_product_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Download Product Image'
        )
		->addColumn(
            'pdf_button',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Pdf Button'
        )
		->addColumn(
            'print',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Print'
        )
		->addColumn(
            'allow_product_saving',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Allow Product Saving'
        )
		->addColumn(
            'tooltips',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'tooltips'
        )
		->addColumn(
            'max_image_size',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Max Image Size'
        )
		->addColumn(
            'min_dpi',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Min Dpi'
        )
		->addColumn(
            'facebook_app_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Facebook App Id'
        )
		->addColumn(
            'instagram_client_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Instagram Client id'
        )
		->addColumn(
            'google_font_client_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Google Font Client Id'
        )
		->addColumn(
            'zoom_step',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            ['nullable' => false],
            'Zoom Step'
        )
		->addColumn(
            'max_zoom',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Max Zoom'
        )
		->addColumn(
            'padding_controls',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'padding_control'
        )
		->addColumn(
            'replace_initial_elements',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Replace Initial Elements'
        )
		->addColumn(
            'open_in_lightbox',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'Open In Lightbox'
        )
		->addColumn(
            'designs_parameter_x',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Designs Parameter X'
        )
		->addColumn(
            'designs_parameter_y',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Designs Parameter Y'
        )
		->addColumn(
            'designs_parameter_z',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Designs Parameter Z'
        )
		->addColumn(
            'designs_parameter_colors',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Colors'
        )
		->addColumn(
            'designs_parameter_price',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Designs Parameter Price'
        )
		->addColumn(
            'designs_parameter_autoCenter',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Auto Center'
        )
		->addColumn(
            'designs_parameter_draggable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Draggable'
        )
		->addColumn(
            'designs_parameter_rotatable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Rotatable'
        )
		->addColumn(
            'designs_parameter_resizable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Resizable'
        )
		->addColumn(
            'designs_parameter_zChangeable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter zChangeable'
        )
		->addColumn(
            'designs_parameter_replace',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Replace'
        )
		->addColumn(
            'designs_parameter_autoSelect',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Auto Select'
        )
		->addColumn(
            'designs_parameter_topped',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Topped'
        )
		->addColumn(
            'designs_parameter_bounding_box_control',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Bounding Box Control'
        )
		->addColumn(
            'designs_parameter_bounding_box_by_other',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Bounding Box By Other'
        )
		->addColumn(
            'designs_parameter_bounding_box_x',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Bounding Box X'
        )
		->addColumn(
            'designs_parameter_bounding_box_y',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Bounding Box Y'
        )
		->addColumn(
            'designs_parameter_bounding_box_width',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Bounding Box Width'
        )
		->addColumn(
            'designs_parameter_bounding_box_height',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Bounding Box Height'
        )
		->addColumn(
            'designs_parameter_boundingBoxClipping',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Designs Parameter Bounding Box Clipping'
        )
		->addColumn(
            'designs_parameter_filters',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Designs Parameter Filters'
        )
		->addColumn(
            'uploaded_designs_parameter_minW',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Uploaded Designs Parameter minW'
        )
		->addColumn(
            'uploaded_designs_parameter_minH',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Uploaded Designs Parameter minH'
        )
		->addColumn(
            'uploaded_designs_parameter_maxW',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Uploaded Designs Parameter maxW'
        )
		->addColumn(
            'uploaded_designs_parameter_maxH',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Uploaded Designs Parameter maxH'
        )
		->addColumn(
            'uploaded_designs_parameter_resizeToW',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Uploaded Designs Parameter ResizeToW'
        )
		->addColumn(
            'uploaded_designs_parameter_resizeToH',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Uploaded Designs Parameter ResizeToH'
        )
		->addColumn(
            'custom_texts_parameter_x',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter X'
        )
		->addColumn(
            'custom_texts_parameter_y',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Y'
        )
		->addColumn(
            'custom_texts_parameter_z',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Z'
        )
		->addColumn(
            'custom_texts_parameter_colors',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Colors'
        )
		->addColumn(
            'custom_texts_parameter_price',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Custom Texts Parameter Price'
        )
		->addColumn(
            'custom_texts_parameter_autoCenter',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Price AutoCenter'
        )
		->addColumn(
            'custom_texts_parameter_draggable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Price Draggable'
        )
		->addColumn(
            'custom_texts_parameter_rotatable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Price Rotatable'
        )
		->addColumn(
            'custom_texts_parameter_resizable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Price Resizable'
        )
		->addColumn(
            'custom_texts_parameter_zChangeable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Price zChangeable'
        )
		->addColumn(
            'custom_texts_parameter_replace',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Replace'
        )
		->addColumn(
            'custom_texts_parameter_autoSelect',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter AutoSelect'
        )
		->addColumn(
            'custom_texts_parameter_topped',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Topped'
        )
		->addColumn(
            'custom_texts_parameter_patternable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Patternable'
        )
		->addColumn(
            'custom_texts_parameter_curvable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Curvable'
        )
		->addColumn(
            'custom_texts_parameter_curveSpacing',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter CurveSpacing'
        )
		->addColumn(
            'custom_texts_parameter_curveRadius',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter CurveRadius'
        )
		->addColumn(
            'custom_texts_parameter_curveReverse',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter CurveReverse'
        )
		->addColumn(
            'custom_texts_parameter_bounding_box_control',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Bounding Box Control'
        )
		->addColumn(
            'custom_texts_parameter_bounding_box_by_other',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Bounding Box By Other'
        )
		->addColumn(
            'custom_texts_parameter_bounding_box_x',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Bounding Box X'
        )
		->addColumn(
            'custom_texts_parameter_bounding_box_y',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Bounding Box Y'
        )
		->addColumn(
            'custom_texts_parameter_bounding_box_width',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Bounding Box Width'
        )
		->addColumn(
            'custom_texts_parameter_bounding_box_height',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Bounding Box Height'
        )
		->addColumn(
            'custom_texts_parameter_boundingBoxClipping',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            [],
            'Custom Texts Parameter Bounding Box Clipping'
        )
		->addColumn(
            'custom_texts_parameter_textSize',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Custom Texts Parameter TextSize'
        )
		->addColumn(
            'font',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Fonts'
        )
		->addColumn(
            'custom_texts_parameter_maxLength',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false],
            'Custom Texts Parameter MaxLength'
        )
		->addColumn(
            'custom_texts_parameter_textAlign',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Custom Texts Parameter Text Align'
        )
		->addColumn(
            'common_parameter_originX',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Common Parameter OriginX'
        )
		->addColumn(
            'common_parameter_originY',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Common Parameter OriginY'
        )
		->addColumn(
            'common_fonts',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Common Fonts'
        )
		->addColumn(
            'google_webfonts',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Google Webfonts'
        )
		->addColumn(
            'fonts_directory',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Fonts Directory'
        )
		/*{{CedAddTableColumn}}}*/
		->setComment(
            'Chilliapple Customizeproducts customizeproducts_customsettings'
        );
		
		$installer->getConnection()->createTable($table);
		
		
		/**
         * Create table 'customizeproducts_customizeproductsdefault'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_customizeproductsdefault')
        )
		->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_customizeproductsdefault'
        )
		->addColumn(
            'id_product',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Product Id'
        )
		->addColumn(
            '_customize_product',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            4,
            [],
            'Is Customize Product'
        )
		->addColumn(
            'cpd_products',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'5M',
            [],
            'Cpd Products'
        )
		->addColumn(
            'cpd_product_categories',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'5M',
            [],
            'Cpd Product Categories'
        )
		->addColumn(
            'cpd_product_settings',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'20M',
            [],
            'Cpd Product Settings'
        )
		->addColumn(
            'cpd_source_type',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'5M',
            [],
            'Cpd Source Type'
        )
		/*{{CedAddTableColumn}}}*/
		
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_customizeproductsdefault'
        );
		
		$installer->getConnection()->createTable($table);
		
		/**
         * Create table 'customizeproducts_prodtocat'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_prodtocat')
        )
		->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Product Id'
        )
		->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            4,
            [],
            'Category Id'
        )
		/*{{CedAddTableColumn}}}*/
		
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_prodtocat'
        );
		
		$installer->getConnection()->createTable($table);
		
		/**
         * Create table 'customizeproducts_customizecartdata'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('customizeproducts_customizecartdata')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'customizeproducts_customizecartdata'
        )
		->addColumn(
            'session_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            50,
            [],
            'Session Id'
        )
		->addColumn(
            'quote_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Quote Id'
        )
		->addColumn(
            'quote_item_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Quote Item Id'
        )
		->addColumn(
            'order_increment_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            20,
            [],
            'Order Increment Id'
        )
		->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Order Id'
        )
		->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            [],
            'Product Id'
        )
		->addColumn(
            'image_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Image Name'
        )
		->addColumn(
            'data',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '20M',
            [],
            'Data'
        )
		->addColumn(
            'new_price',
            \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
            '20,6',
            [],
            'New Price'
        )
		->addColumn(
            'old_price',
            \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
            '20,6',
            [],
            'Old Price'
        )
		->addColumn(
            'from',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'From'
        )
		/*{{CedAddTableColumn}}}*/
		
        ->setComment(
            'Chilliapple Customizeproducts customizeproducts_prodtocat'
        );
		
		$installer->getConnection()->createTable($table);
		
		
		$quoteAddressTable = 'quote_address';
        $quoteTable = 'quote';
        $orderTable = 'sales_order';
        $invoiceTable = 'sales_invoice';
        $creditmemoTable = 'sales_creditmemo';
        //Setup two columns for quote, quote_address and order
        //Quote address tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Customization Fee'
                ]
            );
        $setup->getConnection()
            ->addColumn(
              $setup->getTable($quoteAddressTable),
                'base_customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Base Customization Fee'
                ]
            );
        //Quote tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Customization Fee'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'base_customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Base Customization Fee'
                ]
            );
        //Order tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Customization Fee'
                ]
            );
         $setup->getConnection()
             ->addColumn(
                $setup->getTable($orderTable),
                'base_customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Base Customization Fee'
                ]
            );
        //Invoice tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Customization Fee'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'base_customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Base Customization Fee'
                ]
            );
        //Credit memo tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($creditmemoTable),
                'customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Customization Fee'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($creditmemoTable),
                'base_customfee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Base Customization Fee'
                ]
            );
			
		/*$installer->getConnection()->modifyColumn(
			$installer->getTable('quote_item_option'),
			'value',
			'widget_code',
			[
				'type' => 'longtext'
			]
		);
		
		$installer->getConnection()->modifyColumn(
			$installer->getTable('sales_order_item'),
			'product_options',
			'widget_code',
			[
				'type' => 'longtext'
			]
		);*/

        $installer->endSetup();

    }
}
