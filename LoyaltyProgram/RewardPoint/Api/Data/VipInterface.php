<?php
namespace LoyaltyProgram\RewardPoint\Api\Data;

interface VipInterface
{
    const ID = 'vip_id';
    const NAME = 'vip_name';
    const DESCRIPTION = 'vip_description';
    const GOAL_ID = 'goal_id';
    const RATE = 'vip_rate';

    public function getId();

    public function setId($vip_id);

    public function getName();

    public function setName($vip_name);

    public function getDescription();

    public function setDescription($vip_description);

    public function getGoalId();

    public function setGoalId($goal_id);

    public function getRate();

    public function setRate($vip_rate);

}
