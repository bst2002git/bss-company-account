<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_CompanyAccount
 * @author     Extension Team
 * @copyright  Copyright (c) 2020 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\CompanyAccount\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @package Bss\CompanyAccount\Setup
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * Create main table for module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable('bss_sub_role')
            ->addColumn(
                'role_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Role Identifier'
            )->addColumn(
                'role_name',
                Table::TYPE_TEXT,
                128,
                [
                    'default' => 'N/A'
                ],
                'Role name'
            )->addColumn(
                'role_type',
                Table::TYPE_TEXT,
                128,
                [
                    'nullable' => false
                ],
                'Permissions'
            )->addColumn(
                'order_per_day',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true
                ],
                'Number of order per day'
            )->addColumn(
                'max_order_amount',
                Table::TYPE_DECIMAL,
                '20,4',
                [
                    'nullable' => true
                ],
                'Max amount of order'
            )->setComment('Roles Table');
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('bss_sub_user'))
            ->addColumn(
                'sub_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Sub User Identifier'
            )->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true
                ],
                'Company Account is belong to'
            )->addColumn(
                'sub_name',
                Table::TYPE_TEXT,
                128,
                [
                    'nullable' => false,
                    'default' => 'N/A'
                ],
                'Sub User\'s Name'
            )->addColumn(
                'sub_email',
                Table::TYPE_TEXT,
                128,
                [
                    'nullable' => true
                ],
                'Sub User\'s Email'
            )->addColumn(
                'sub_password',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'Sub User\'s Password'
            )->addColumn(
                'sub_status',
                Table::TYPE_SMALLINT,
                6,
                [
                    'default' => 0
                ],
                'Sub User\'s Status'
            )->addColumn(
                'role_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                    'default' => 0
                ],
                'The role is belong to user'
            )->addColumn(
                'token',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Sub User\'s Token'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Create Time'
            )->addColumn(
                'quote_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true
                ],
                'Quote Id'
            )->addColumn(
                'parent_quote_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true
                ],
                'Associated Company Account Quote Id'
            )->addIndex(
                $installer->getIdxName('bss_sub_user', ['customer_id']),
                ['customer_id']
            )->addIndex(
                $installer->getIdxName('bss_sub_user', ['role_id']),
                ['role_id']
            )->addForeignKey(
                $installer->getFkName(
                    'bss_sub_user',
                    'customer_id',
                    'customer_entity',
                    'entity_id'
                ),
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'bss_sub_user',
                    'role_id',
                    'bss_sub_role',
                    'role_id'
                ),
                'role_id',
                $installer->getTable('bss_sub_role'),
                'role_id',
                Table::ACTION_CASCADE
            )->setComment('Bss Sub User');
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable('bss_sub_user_order')
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Sub user order identifier'
            )->addColumn(
                'sub_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true
                ],
                'Sub user id'
            )->addColumn(
                'order_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true
                ],
                'Order Id'
            )->addColumn(
                'grand_total',
                Table::TYPE_DECIMAL,
                '20,4',
                [
                    'nullable' => true
                ],
                'Grand total'
            )->addIndex(
                $installer->getIdxName('bss_sub_user_order', ['sub_id']),
                ['sub_id']
            )->addForeignKey(
                $installer->getFkName(
                    'bss_sub_user_order',
                    'sub_id',
                    'bss_sub_user',
                    'sub_id'
                ),
                'sub_id',
                $installer->getTable('bss_sub_user'),
                'sub_id',
                Table::ACTION_CASCADE
            )->setComment('Sub User Order');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
