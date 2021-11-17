<?php
declare(strict_types=1);

namespace Bss\LensSystem\Setup;

use Bss\LensSystem\Model\ResourceModel\Attribute\ConditionCollection;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * class LensConditionSetup
 * Setup attribute for condition
 */
class LensConditionSetup extends EavSetup
{
    const ENTITY_TYPE_CODE = 'lenssystem_condition';

    const EAV_ENTITY_TYPE_CODE = 'lenssystem';

    /**
     * @return array
     */
    protected function getAttributes()
    {
        $attributes = [];
        $attributes['condition_title'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Condition Title',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '10',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];

        $attributes['condition_mode'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Condition Title',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '10',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];

        $attributes['condition_value'] = [
            'group' => 'General',
            'type' => 'text',
            'label' => 'Condition Value',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '10',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];

        return $attributes;
    }

    /**
     * Retrieve default entities
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        $entities = [
            self::ENTITY_TYPE_CODE => [
                'entity_model' => \Bss\LensSystem\Model\ResourceModel\LensCondition::class,
                'attribute_model' => \Bss\LensSystem\Model\ResourceModel\Eav\ConditionAttribute::class,
                'table' => self::ENTITY_TYPE_CODE,
                'increment_model' => null,
                'additional_attribute_table' => 'lenssystem_eav_attribute',
                'entity_attribute_collection' => ConditionCollection::class,
                'attributes' => $this->getAttributes(),
            ],
        ];
        return $entities;
    }
}
