<?php

namespace LoyaltyProgram\RewardPoint\Model;

use LoyaltyProgram\RewardPoint\Api\Data\VipInterface;

class Vip extends \Magento\Framework\Model\AbstractModel implements VipInterface
{
    const CACHE_TAG = 'vip';

    protected $_cacheTag = 'vip';

    protected $_eventPrefix = 'vip';

    protected function _construct()
    {
        $this->_init('LoyaltyProgram\RewardPoint\Model\ResourceModel\Vip');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($vip_id)
    {
        return $this->setData(self::ID, $vip_id);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($vip_name)
    {
        return $this->setData(self::NAME, $vip_name);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($vip_description)
    {
        return $this->setData(self::DESCRIPTION, $vip_description);
    }

    public function getGoalId()
    {
        return $this->getData(self::GOAL_ID);
    }

    public function setGoalId($goal_id)
    {
        return $this->setData(self::GOAL_ID, $goal_id);
    }

    public function getRate()
    {
        return $this->getData(self::RATE);
    }

    public function setRate($vip_rate)
    {
        return $this->setData(self::RATE, $vip_rate);
    }
}
