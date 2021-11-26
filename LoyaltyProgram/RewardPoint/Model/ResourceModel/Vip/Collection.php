<?php

namespace LoyaltyProgram\RewardPoint\Model\ResourceModel\Vip;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'vip_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'LoyaltyProgram\RewardPoint\Model\Vip',
            'LoyaltyProgram\RewardPoint\Model\ResourceModel\Vip'
        );
    }
}
