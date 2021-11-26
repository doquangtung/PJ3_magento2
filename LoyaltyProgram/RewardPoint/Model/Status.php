<?php

namespace LoyaltyProgram\RewardPoint\Model;

use Magento\Framework\Data\OptionSourceInterface;
use LoyaltyProgram\RewardPoint\Model\GoalFactory;

class Status implements OptionSourceInterface
{
    protected $goalFactory;
    public function __construct(
        \LoyaltyProgram\RewardPoint\Model\GoalFactory $goalFactory
    )     {
        $this->goalFactory = $goalFactory;
    }
    public function getCollection()
    {
        return $this->goalFactory->create()->getCollection();
    }
    public function getOptionGoal()
    {
        $goals = $this->getCollection();
        foreach ($goals as $goal)  {
            $goalOptions[] = ['value' => $goal->getId(), 'label' => $goal->getName()];
        }
        return $goalOptions;
    }
    
    /**
     * Get Grid row status type labels array.
     * @return array
     */
    public function getOptionArray()
    {
        $options = ['Point' => __('Point'),'Order' => __('Order'),'USD' => __('USD')];
        return $options;
    }
    public function getOptionTF()
    {
        $options = ['1' => __('Yes'),'0' => __('No')];
        return $options;
    }
    public function getOptionWeb()
    {
        $options = ['1' => __('Main Website'),'0' => __('Admin')];
        return $options;
    }
    /**
     * Get Grid row status labels array with empty value for option element.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get Grid row type array for option element.
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
