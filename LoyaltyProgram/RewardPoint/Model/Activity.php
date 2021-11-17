<?php

namespace LoyaltyProgram\RewardPoint\Model;

use LoyaltyProgram\RewardPoint\Api\Data\ActivityInterface;

class Activity extends \Magento\Framework\Model\AbstractModel implements ActivityInterface
{
    const CACHE_TAG = 'earn';

    protected $_cacheTag = 'earn';

    protected $_eventPrefix = 'earn';

    protected function _construct()
    {
        $this->_init('LoyaltyProgram\RewardPoint\Model\ResourceModel\Activity');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($earn_id)
    {
        return $this->setData(self::ID, $earn_id);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($earn_name)
    {
        return $this->setData(self::NAME, $earn_name);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($earn_description)
    {
        return $this->setData(self::DESCRIPTION, $earn_description);
    }

    public function getStart()
    {
        return $this->getData(self::START);
    }

    public function setStart($earn_start)
    {
        return $this->setData(self::START, $earn_start);
    }

    public function getEnd()
    {
        return $this->getData(self::END);
    }

    public function setEnd($earn_end)
    {
        return $this->setData(self::END, $earn_end);
    }

    public function getActive()
    {
        return $this->getData(self::ACTIVE);
    }

    public function setActive($earn_actived)
    {
        return $this->setData(self::ACTIVE, $earn_actived);
    }

    public function getGoalId()
    {
        return $this->getData(self::GOAL_ID);
    }

    public function setGoalId($goal_id)
    {
        return $this->setData(self::GOAL_ID, $goal_id);
    }

    public function getWebId()
    {
        return $this->getData(self::WEB_ID);
    }

    public function setWebId($website_id)
    {
        return $this->setData(self::WEB_ID, $website_id);
    }

    public function getPriority()
    {
        return $this->getData(self::PRIORITY);
    }

    public function setPriority($earn_priority)
    {
        return $this->setData(self::PRIORITY, $earn_priority);
    }

    public function getOverlap()
    {
        return $this->getData(self::OVERLAP);
    }

    public function setOverlap($earn_overlap)
    {
        return $this->setData(self::OVERLAP, $earn_overlap);
    }
}
