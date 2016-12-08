<?php

namespace Accenture\Shopfinder\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;

        $installer->startSetup();


        $table = $setup->getConnection()->newTable($setup->getTable('shop'))
                ->addColumn('shop_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false,
                    'primary' => true], 'Shop Id')
                ->addColumn('shop_name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Shop Name')
                ->addColumn('shop_county', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Shop Country')


            ->addColumn('shop_identifier',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,['identity' => true,'nullable' => false],'Shop Identifier')
             ->addColumn('shop_address',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,[],'Shop Address')
             ->addColumn('shop_address1',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,[],'Shop Address1')
             ->addColumn('shop_city',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,[],'Shop City')
            ->addColumn('shop_state',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,[],'Shop State')
            ->addColumn('shop_postal',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,10,[],'Shop Postal')
            ->addColumn('shop_phone',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,100,[],'Shop Phone')
            ->addColumn('shop_latitude',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,100,[],'Shop Latitude')
            ->addColumn('shop_longtitude',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,100,[],'Shop Longtitude')
            ->addColumn('shop_email',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,[],'Shop Email')
            ->addColumn('shop_image_path',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,255,[],'Shop Image Path')
            ->addColumn('shop_status',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['nullable' => false],'Shop Status')
            ->addColumn('shop_collect',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['nullable' => false],'Shop Collect')
            ->addColumn('shop_description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,'64M',[],'Shop Description')
            ->addColumn('shop_timings',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,'64M',[],'Shop Timings')
            ->addColumn('shop_view',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['nullable' => false],'Shop View')
            ->addColumn('store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,['nullable' => false],'Store Id')
            ->addColumn('shop_created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null,['nullable' => false],'Shop Created At')
            ->addColumn('shop_modified_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null,['nullable' => false], 'Shop Modified At')
        ->addIndex(
            $installer->getIdxName('shop', ['shop_name']),
            ['shop_name']
        )->addIndex(
            $installer->getIdxName('shop', ['shop_identifier']),
            ['shop_identifier']
        )->addIndex(
            $installer->getIdxName('shop', ['shop_created_at']),
            ['shop_created_at']
        )->addIndex(
            $installer->getIdxName('shop', ['shop_modified_at']),
            ['shop_modified_at']
        )
        ->setComment('Shopfinder Schema');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}
