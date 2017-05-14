<?php

namespace Retailexpress\Giftcard\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $quoteTable = 'quote';
        $orderTable = 'sales_order';

	    $setup->getConnection()
		    ->addColumn(
			    $setup->getTable($quoteTable),
			    'giftcard_code',
			    [
				    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				    255,
				    'default' => '',
				    'nullable' => true,
				    'comment' =>'Gift Card Code'
			    ]
		    );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'giftcard_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Gift Card Amount'
                ]
            );


	    $setup->getConnection()
		    ->addColumn(
			    $setup->getTable($quoteTable),
			    'base_giftcard_amount',
			    [
				    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
				    '10,2',
				    'default' => 0.00,
				    'nullable' => true,
				    'comment' =>'Base Gift Card Amount'
			    ]
		    );

	    $setup->getConnection()
		    ->addColumn(
			    $setup->getTable($orderTable),
			    'giftcard_code',
			    [
				    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				    255,
				    'default' => '',
				    'nullable' => true,
				    'comment' =>'Gift Card Code'
			    ]
		    );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'giftcard_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Gift Card Amount'

                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'base_giftcard_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Base Gift Card Amount'

                ]
            );

        $setup->endSetup();
    }
}