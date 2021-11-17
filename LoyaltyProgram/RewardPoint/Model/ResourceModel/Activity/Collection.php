<?php

namespace LoyaltyProgram\RewardPoint\Model\ResourceModel\Activity;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'earn_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'LoyaltyProgram\RewardPoint\Model\Activity',
            'LoyaltyProgram\RewardPoint\ResourceModel\Activity'
        );
    }
}
