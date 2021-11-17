<?php

namespace LoyaltyProgram\RewardPoint\Model\ResourceModel\Goal;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'goal_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'LoyaltyProgram\RewardPoint\Model\Goal',
            'LoyaltyProgram\RewardPoint\ResourceModel\Goal'
        );
    }
}
