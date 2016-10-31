<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Setup;

use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface {
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context){
        $setup->startSetup();

        $table_name = 'trive_revo';

        /**
         * Create table 'trive_revo'
         */
        $table = $setup->getConnection()->newTable($setup->getTable($table_name))
                ->addColumn('slider_id',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            null,
                            ['nullable' => false, 'unsigned' => true, 'identity' => true, 'primary' => true],
                            'Slider ID')
                ->addColumn('title',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            256,
                            [],
                            'Slider title')
                ->addColumn('display_title',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Display title')
                ->addColumn('status',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['nullable' => false, 'default' => 1],
                            'Slider status')
                ->addColumn('description',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            null,
                            [],
                            'Description')
                ->addColumn('type',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            256,
                            [],
                            'Slyder type')
                ->addColumn('grid',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Display items grid')
                ->addColumn('exclude_from_cart',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Don\'t display slider on cart page ')
                ->addColumn('exclude_from_checkout',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Don\'t display slider on checkout ')
                ->addColumn('location',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            256,
                            [],
                            'Slider location')
                ->addColumn('start_time',
                            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                            null,
                            [],
                            'Slider start time')
                ->addColumn('end_time',
                            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                            null,
                            [],
                            'Slider end time')
                ->addColumn('navigation',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Navigation dots')
                ->addColumn('infinite',
                            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                            null,
                            [],
                            'Infinite loop')
                ->addColumn('slides_to_show',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to show')
                ->addColumn('slides_to_scroll',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to scroll')
                ->addColumn('speed',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Speed')
                ->addColumn('autoplay',
                            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                            null,
                            [],
                            'Autoplay')
                ->addColumn('autoplay_speed',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Autoplay speed')
                ->addColumn('rtl',
                            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                            null,
                            [],
                            'Right to left')
                ->addColumn('breakpoint_large',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Large breakpoint')
                ->addColumn('large_slides_to_show',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to show for large')
                ->addColumn('large_slides_to_scroll',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to scroll for large')
                ->addColumn('breakpoint_medium',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Medium breakpoint')
                ->addColumn('medium_slides_to_show',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to show for medium')
                ->addColumn('medium_slides_to_scroll',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to scroll for Medium')
                ->addColumn('breakpoint_small',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Small breakpoint')
                ->addColumn('small_slides_to_show',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to show for small')
                ->addColumn('small_slides_to_scroll',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            [],
                            'Slides to scroll for small')
                ->addColumn('display_price',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false, 'default' => 1],
                            'Display product price')
                ->addColumn('display_cart',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false, 'default' => 1],
                            'Display add to cart button')
                ->addColumn('display_wishlist',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false, 'default' => 1],
                            'Display add to wish list')
                ->addColumn('display_compare',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false, 'default' => 1],
                            'Display add to compare')
                ->addColumn('products_number',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false],
                            'Number of products in slider')
                ->addColumn('enable_swatches',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false],
                            'Enable color swatches')
                ->addColumn('enable_ajaxcart',
                            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                            null,
                            ['unsigned' => true, 'nullable' => false],
                            'Enable ajax add to cart')

                ->addIndex($setup->getIdxName($table_name,'slider_id'),'slider_id')
                ->setComment('Trive Main Product Slider Table');

        $setup->getConnection()->createTable($table);

        // Create table for featured and additional slider products
        $table_name = 'trive_revo_products';

        $table = $setup->getConnection()->newTable($setup->getTable($table_name))
            ->addColumn('slider_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false, 'unsigned' => true, 'primary' => true],
                        'Slider ID')
            ->addColumn('product_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false, 'unsigned' => true, 'primary' => true],
                        'Product ID')
            ->addColumn('position',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false, 'default' => '0'],
                        'Position')
            ->addIndex($setup->getIdxName($table_name,'product_id'),'product_id')
            ->addForeignKey($setup->getFkName($table_name,'slider_id','trive_revo','slider_id'),
                            'slider_id',
                            $setup->getTable('trive_revo'),
                            'slider_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName($table_name,'product_id','catalog_product_entity','entity_id'),
                            'product_id',
                            $setup->getTable('catalog_product_entity'),
                            'entity_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Catalog Product To Slider Linkage Table');

        $setup->getConnection()->createTable($table);

//        Create table for managing sliders and stores
        $table_name = 'trive_revo_stores';
        $table = $setup->getConnection()->newTable($setup->getTable($table_name))
            ->addColumn('slider_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable' => false, 'unsigned' => true, 'primary' => true],
                        'Slider ID')
            ->addColumn('store_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        null,
                        ['unsigned' => true, 'nullable' => false, 'primary' => true],
                        'Store ID')
            ->addIndex($setup->getIdxName($table_name,['store_id']),['store_id'])
            ->addForeignKey($setup->getFkName($table_name,'slider_id','trive_revo','slider_id'),
                'slider_id',
                'trive_revo',
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName($table_name,'store_id','store','store_id'),
                'store_id',
                'store',
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Revo store table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}