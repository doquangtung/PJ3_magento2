<?php
declare(strict_types=1);

namespace Bss\LensSystem\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * Install LensSystem Schema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var EavTablesSetupFactory
     */
    protected $eavTablesSetupFactory;

    /**
     * Init
     *
     * @internal param EavTablesSetupFactory $EavTablesSetupFactory
     */
    public function __construct(
        EavTablesSetupFactory $eavTablesSetupFactory
    ) {
        $this->eavTablesSetupFactory = $eavTablesSetupFactory;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $lensOptions = LensOptionsSetup::ENTITY_TYPE_CODE;
        $lensStep = LensStepsSetup::ENTITY_TYPE_CODE;
        $lensCondition = LensConditionSetup::ENTITY_TYPE_CODE;
        /**
         * Create entity Table
         */
        $tableFittingHeight = $setup->getConnection()->newTable($setup->getTable('lenssystem_fittingheight'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )->addColumn(
                'lens_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Type'
            )->addColumn(
                'lens_height',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Height'
            )->addColumn(
                'fitting_height',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Fitting Height'
            );

        $tableLenses = $setup->getConnection()->newTable($setup->getTable('lenssystem_lenses'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )->addColumn(
                'active',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                255,
                [
                    'nullable' => false,
                    'default' => true
                ],
                'Lens Status'
            )->addColumn(
                'serial',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                [
                    'nullable' => true
                ],
                'Lens Serial'
            )->addColumn(
                'eyewear_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Eyewear Type'
            )->addColumn(
                'lens_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Type'
            )->addColumn(
                'lens_func',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Function'
            )->addColumn(
                'lens_pkg',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Package'
            )->addColumn(
                'lens_color',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Color'
            )->addColumn(
                'selected_upgrade_options',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Selected Upgrade Option'
            )->addColumn(
                'lens_index',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Index'
            )->addColumn(
                'lens_group',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Group'
            )->addColumn(
                'lens_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Code'
            )->addColumn(
                'coating_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Coating Name'
            )->addColumn(
                'coating_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Coating Code'
            )->addColumn(
                'tint_color_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Tint Color Code'
            )->addColumn(
                'lens_absorption',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Absorption'
            )->addColumn(
                'lens_diameter',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Lens Diameter'
            )->addColumn(
                'available_diameter',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Available Diameter'
            )->addColumn(
                'power_minus_lower',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Power Minus Lower'
            )->addColumn(
                'power_minus_higher',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Power Minus Higher'
            )->addColumn(
                'power_plus_lower',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Power Plus Lower'
            )->addColumn(
                'power_plus_higher',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Power Plus Higher'
            )->addColumn(
                'cyl_minus_lower',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Cyl Minus Lower'
            )->addColumn(
                'cyl_minus_higher',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Cyl Minus Higher'
            )->addColumn(
                'cyl_plus_lower',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Cyl Plus Lower'
            )->addColumn(
                'cyl_plus_higher',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Cyl Plus Higher'
            )->addColumn(
                'add_min',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Add min'
            )->addColumn(
                'add_max',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true
                ],
                'Add max'
            );

        $tableOptions = $setup->getConnection()
            ->newTable($setup->getTable($lensOptions))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->setComment('Entity Table');
        $tableOptions->addColumn(
            'entity_type_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ],
            'Entity Type ID'
        )->addIndex(
            $setup->getIdxName($lensOptions, ['entity_type_id']),
            ['entity_type_id']
        )->addForeignKey(
            $setup->getFkName(
                'lenssystem_options',
                'entity_type_id',
                'eav_entity_type',
                'entity_type_id'
            ),
            'entity_type_id',
            $setup->getTable('eav_entity_type'),
            'entity_type_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        $tableOptions->addColumn(
            'attribute_set_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ],
            'Attribute Set ID'
        )->addIndex(
            $setup->getIdxName($lensOptions, ['attribute_set_id']),
            ['attribute_set_id']
        )->addForeignKey(
            $setup->getFkName(
                'lenssystem_options',
                'attribute_set_id',
                'eav_attribute_set',
                'attribute_set_id'
            ),
            'attribute_set_id',
            $setup->getTable('eav_attribute_set'),
            'attribute_set_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        // Add more static attributes here...
        $tableOptions->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        );

        $stepTable = $setup->getConnection()
            ->newTable($setup->getTable($lensStep))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->setComment('Entity Table');
        $stepTable->addColumn(
            'entity_type_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ],
            'Entity Type ID'
        )->addIndex(
            $setup->getIdxName($lensStep, ['entity_type_id']),
            ['entity_type_id']
        )->addForeignKey(
            $setup->getFkName(
                'lenssystem_steps',
                'entity_type_id',
                'eav_entity_type',
                'entity_type_id'
            ),
            'entity_type_id',
            $setup->getTable('eav_entity_type'),
            'entity_type_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        $stepTable->addColumn(
            'attribute_set_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ],
            'Attribute Set ID'
        )->addIndex(
            $setup->getIdxName($lensStep, ['attribute_set_id']),
            ['attribute_set_id']
        )->addForeignKey(
            $setup->getFkName(
                'lenssystem_steps',
                'attribute_set_id',
                'eav_attribute_set',
                'attribute_set_id'
            ),
            'attribute_set_id',
            $setup->getTable('eav_attribute_set'),
            'attribute_set_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        // Add more static attributes here...
        $stepTable->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        );

        // Condition table
        $conditionTable = $setup->getConnection()
            ->newTable($setup->getTable($lensCondition))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->setComment('Entity Table');
        $conditionTable->addColumn(
            'entity_type_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ],
            'Entity Type ID'
        )->addIndex(
            $setup->getIdxName($lensCondition, ['entity_type_id']),
            ['entity_type_id']
        )->addForeignKey(
            $setup->getFkName(
                'lenssystem_condition',
                'entity_type_id',
                'eav_entity_type',
                'entity_type_id'
            ),
            'entity_type_id',
            $setup->getTable('eav_entity_type'),
            'entity_type_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        $conditionTable->addColumn(
            'attribute_set_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ],
            'Attribute Set ID'
        )->addIndex(
            $setup->getIdxName($lensCondition, ['attribute_set_id']),
            ['attribute_set_id']
        )->addForeignKey(
            $setup->getFkName(
                'lenssystem_condition',
                'attribute_set_id',
                'eav_attribute_set',
                'attribute_set_id'
            ),
            'attribute_set_id',
            $setup->getTable('eav_attribute_set'),
            'attribute_set_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

        $conditionTable->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        );

        $setup->getConnection()->createTable($tableOptions);
        $setup->getConnection()->createTable($stepTable);
        $setup->getConnection()->createTable($conditionTable);
        $setup->getConnection()->createTable($tableFittingHeight);
        $setup->getConnection()->createTable($tableLenses);
        $eavTablesSetup = $this->eavTablesSetupFactory->create(['setup' => $setup]);
        $eavTablesSetup->createEavTables(LensOptionsSetup::ENTITY_TYPE_CODE);
        $eavTablesSetup->createEavTables(LensStepsSetup::ENTITY_TYPE_CODE);
        $eavTablesSetup->createEavTables(LensConditionSetup::ENTITY_TYPE_CODE);
        $setup->endSetup();
    }
}
