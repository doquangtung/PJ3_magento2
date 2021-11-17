<?php

namespace LoyaltyProgram\RewardPoint\Model;

use Magento\Framework\Data\OptionSourceInterface;
// use LoyaltyProgram\RewardPoint\Model\GoalFactory;

class Status implements OptionSourceInterface
{
    // protected $goalFactory;
    // public function __construct(
    //     Context $context,
    //     \LoyaltyProgram\RewardPoint\Model\GoalFactory $goalFactory,
    //     array $data = array()
    // )     {
    //     $this->goalFactory = $goalFactory;
    //     parent::__construct($context, $data);
    // }
    // public function getCollection()
    // {
    //     return $this->goalFactory->create()->getCollection();
    // }
    // public function getOptionGoal()
    // {
    //     $goals = $this->getCollection();
    //     foreach ($goals as $goal)  {
    //         $goalOptions[] = ['value' => $goal->getId(), 'label' => $goal->getName()];
    //     }
    //     return $goalOptions;
    // }
    
    /**
     * Get Grid row status type labels array.
     * @return array
     */
    public function getOptionArray()
    {
        $options = ['Point' => __('Point'),'Order' => __('Order'),'USD' => __('USD')];
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
