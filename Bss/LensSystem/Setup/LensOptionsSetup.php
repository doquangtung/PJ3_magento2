<?php
declare(strict_types=1);

namespace Bss\LensSystem\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * Class LensOptionsSetup
 * Setup LensOptions
 */
class LensOptionsSetup extends EavSetup
{
    const ENTITY_TYPE_CODE = 'lenssystem_options';

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
        $attributes['option_id'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Option ID',
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
        $attributes['title'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Title',
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

        $attributes['description'] = [
            'group' => 'General',
            'type' => 'text',
            'label' => 'Description',
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

        $attributes['description_short'] = [
            'group' => 'General',
            'type' => 'text',
            'label' => 'Description Short',
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

        $attributes['tooltip_title'] = [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'Tooltip Title',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '5',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];

        $attributes['tooltip_image'] = [
            'type' => 'varchar',
            'label' => 'Tooltip Image',
            'required' => false,
            'sort_order' => '6',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General Information',
        ];
        $attributes['tooltip_body'] = [
            'group' => 'General',
            'type' => 'text',
            'label' => 'Tooltip Body',
            'input' => 'text',
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'required' => '0',
            'user_defined' => false,
            'default' => '',
            'unique' => false,
            'position' => '7',
            'note' => '',
            'visible' => '1',
            'wysiwyg_enabled' => '0',
        ];
        $attributes['image'] = [
            'type' => 'varchar',
            'label' => 'Image',
            'required' => false,
            'sort_order' => '6',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General Information',
        ];
        $attributes['image_revert'] = [
            'type' => 'varchar',
            'label' => 'Image Revert',
            'required' => false,
            'sort_order' => '6',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General Information',
        ];
        $attributes['overlay_image'] = [
            'type' => 'varchar',
            'label' => 'Overlay Image',
            'required' => false,
            'sort_order' => '6',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General Information',
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
                'entity_model' => \Bss\LensSystem\Model\ResourceModel\LensOptions::class,
                'attribute_model' => \Bss\LensSystem\Model\ResourceModel\Eav\Attribute::class,
                'table' => self::ENTITY_TYPE_CODE,
                'increment_model' => null,
                'additional_attribute_table' => 'lenssystem_eav_attribute',
                'entity_attribute_collection' => \Bss\LensSystem\Model\ResourceModel\Attribute\Collection::class,
                'attributes' => $this->getAttributes(),
            ],
        ];
        return $entities;
    }
}
