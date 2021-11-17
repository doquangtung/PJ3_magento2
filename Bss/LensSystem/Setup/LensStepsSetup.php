<?php
declare(strict_types=1);

namespace Bss\LensSystem\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * Class LensStepsSetup
 * LensStepSetup
 */
class LensStepsSetup extends EavSetup
{
    const ENTITY_TYPE_CODE = 'lenssystem_steps';

    const EAV_ENTITY_TYPE_CODE = 'lenssystem';

    /**
     * Retrieve Entity Attributes
     *
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function getAttributes()
    {
        $attributes = [];
        $attributes['step_id'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Step ID',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '1',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];
        $attributes['step_title'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Step Title',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '2',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];
        $attributes['instru'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Instruction',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '3',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];
        $attributes['layout'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Layout',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '4',
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
                'entity_model' => \Bss\LensSystem\Model\ResourceModel\LensSteps::class,
                'attribute_model' => \Bss\LensSystem\Model\ResourceModel\Eav\StepsAttribute::class,
                'table' => self::ENTITY_TYPE_CODE,
                'increment_model' => null,
                'additional_attribute_table' => 'lenssystem_eav_attribute',
                'entity_attribute_collection' => \Bss\LensSystem\Model\ResourceModel\Attribute\StepsCollection::class,
                'attributes' => $this->getAttributes(),
            ],
        ];
        return $entities;
    }
}
