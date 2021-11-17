<?php
declare(strict_types=1);

namespace Bss\LensSystem\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Zend_Db_Exception;

/**
 * Update Step and Option ID to Global Scope
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetupFactory;

    /**
     * UpgradeSchema constructor.
     * @param EavSetup $eavSetupFactory
     */
    public function __construct(
        EavSetup $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->startSetup();

            $table = $setup->getConnection()->newTable(
                $setup->getTable('lens_rules')
            )->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Rule Id'
            )->addColumn(
                'rule_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                [],
                'Name'
            )->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                [],
                'Description'
            )->addColumn(
                'from_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                ['nullable' => true, 'default' => null],
                'From'
            )->addColumn(
                'to_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                ['nullable' => true, 'default' => null],
                'To'
            )->addColumn(
                'is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Is Active'
            )->addColumn(
                'conditions_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '2M',
                [],
                'Conditions Serialized'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Sort Order (Priority)'
            )->addIndex(
                $setup->getIdxName('lens_rules', ['sort_order', 'is_active', 'to_date', 'from_date']),
                ['sort_order', 'is_active', 'to_date', 'from_date']
            )->setComment(
                'Own Rules'
            );

            $setup->getConnection()->createTable($table);

            $setup->endSetup();
        }
    }
}
