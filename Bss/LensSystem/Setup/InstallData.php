<?php
declare(strict_types=1);

namespace Bss\LensSystem\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 * Install LensSystem Data
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var \Bss\LensSystem\Setup\LensOptionsSetupFactory
     */
    protected $lensOptionsSetupFactory;

    /**
     * @var \Bss\LensSystem\Setup\LensStepsSetupFactory
     */
    protected $lensStepsSetupFactory;

    /**
     * @var \Bss\LensSystem\Setup\LensConditionSetupFactory
     */
    protected $lensConditionSetupFactory;

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param \Bss\LensSystem\Setup\LensOptionsSetupFactory $lensOptionsSetupFactory
     * @param \Bss\LensSystem\Setup\LensStepsSetupFactory $lensStepsSetupFactory
     * @param \Bss\LensSystem\Setup\LensConditionSetupFactory $lensConditionSetupFactory
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        LensOptionsSetupFactory $lensOptionsSetupFactory,
        LensStepsSetupFactory $lensStepsSetupFactory,
        LensConditionSetupFactory $lensConditionSetupFactory,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->lensOptionsSetupFactory = $lensOptionsSetupFactory;
        $this->lensStepsSetupFactory = $lensStepsSetupFactory;
        $this->lensConditionSetupFactory = $lensConditionSetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $lensOptionsSetup = $this->lensOptionsSetupFactory->create(['setup' => $setup]);
        $lensStepsSetup = $this->lensStepsSetupFactory->create(['setup' => $setup]);
        $lensConditionSetup = $this->lensConditionSetupFactory->create(['setup' => $setup]);
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $setup->startSetup();

        $lensOptionsSetup->installEntities();
        $lensStepsSetup->installEntities();
        $lensConditionSetup->installEntities();

        $optionEntities = $lensOptionsSetup->getDefaultEntities();
        $stepEntities = $lensStepsSetup->getDefaultEntities();
        $conditionEntities = $lensConditionSetup->getDefaultEntities();

        foreach ($optionEntities as $entityName => $entity) {
            $lensOptionsSetup->addEntityType($entityName, $entity);
        }
        foreach ($stepEntities as $entityName => $entity) {
            $lensStepsSetup->addEntityType($entityName, $entity);
        }
        foreach ($conditionEntities as $entityName => $entity) {
            $lensConditionSetup->addEntityType($entityName, $entity);
        }

        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'condition_dropdown');
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'condition_dropdown', [
            'group' => 'Product Details',
            'type' => 'text',
            'backend' => '',
            'frontend' => '',
            'sort_order' => 200,
            'label' => 'Lens Condition',
            'input' => 'select',
            'class' => '',
            'source' => \Bss\LensSystem\Model\Source\ConditionDropdown::class,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'apply_to' => ''
        ]);

        $setup->endSetup();
    }
}
