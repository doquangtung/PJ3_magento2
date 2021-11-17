<?php
namespace LoyaltyProgram\RewardPoint\Api\Data;

interface GridInterface
{
    const ID = 'goal_id';
    const NAME = 'goal_name';
    const TYPE = 'goal_type';
    const NUMBER = 'goal_number';

    public function getId();

    public function setId($goal_id);

    public function getName();

    public function setName($goal_name);

    public function getType();

    public function setType($goal_type);

    public function getNumber();

    public function setNumber($goal_number);

}
