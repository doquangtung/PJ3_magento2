<?php
namespace LoyaltyProgram\RewardPoint\Api\Data;

interface GridInterface
{
    const ID = 'goal_id';
    const NAME = 'goal_name';
    const TYPE = 'goal_type';
    const NUMBER = 'goal_number';
    const USE_FOR = 'goal_use';

    public function getId();

    public function setId($goal_id);

    public function getName();

    public function setName($goal_name);

    public function getType();

    public function setType($goal_type);

    public function getNumber();

    public function setNumber($goal_number);

    public function getUse();

    public function setUse($goal_use);

}
