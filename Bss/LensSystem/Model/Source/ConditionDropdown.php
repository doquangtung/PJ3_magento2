<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\Source;

use Bss\LensSystem\Model\ResourceModel\LensCondition\CollectionFactory;

/**
 * Class ConditionDropdown
 * Condition dropdown attribute for product
 */
class ConditionDropdown extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var CollectionFactory
     */
    protected $lensConditionFactory;

    /**
     * ConditionDropdown constructor.
     * @param CollectionFactory $lensConditionFactory
     */
    public function __construct(
        CollectionFactory $lensConditionFactory
    ) {
        $this->lensConditionFactory = $lensConditionFactory;
    }

    /**
     * @return array|array[]|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllOptions()
    {
        $conditionCollection = $this->lensConditionFactory->create()->addAttributeToSelect('*');
        $data = [
            ['label' => __('--Select--'), 'value' => '']
        ];
        foreach ($conditionCollection as $item) {
            array_push($data, [
                'label' => $item->getData('condition_title'),
                'value' => $item->getData('entity_id')
            ]);
        }

        if ($this->_options === null) {
            $this->_options = $data;
        }
        return $this->_options;
    }
}
