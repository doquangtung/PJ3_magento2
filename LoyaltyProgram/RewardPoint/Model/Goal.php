<?php

namespace LoyaltyProgram\RewardPoint\Model;

use LoyaltyProgram\RewardPoint\Api\Data\GridInterface;

class Goal extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    const CACHE_TAG = 'goal';

    protected $_cacheTag = 'goal';

    protected $_eventPrefix = 'goal';

    protected function _construct()
    {
        $this->_init('LoyaltyProgram\RewardPoint\Model\ResourceModel\Goal');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($goal_id)
    {
        return $this->setData(self::ID, $goal_id);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($goal_name)
    {
        return $this->setData(self::NAME, $goal_name);
    }

    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    public function setType($goal_type)
    {
        return $this->setData(self::TYPE, $goal_type);
    }

    public function getNumber()
    {
        return $this->getData(self::NUMBER);
    }

    public function setNumber($goal_number)
    {
        return $this->setData(self::NUMBER, $goal_number);
    }
}
