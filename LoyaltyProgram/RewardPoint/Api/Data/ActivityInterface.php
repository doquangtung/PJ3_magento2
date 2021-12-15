<?php
namespace LoyaltyProgram\RewardPoint\Api\Data;

interface ActivityInterface
{
    const ID = 'earn_id';
    const NAME = 'earn_name';
    const DESCRIPTION = 'earn_description';
    const POINT = 'earn_point';
    const START = 'earn_start';
    const END = 'earn_end';
    const ACTIVE = 'earn_actived';
    const GOAL_ID = 'goal_id';
    const PRIORITY = 'earn_priority';
    const OVERLAP = 'earn_overlap';

    public function getId();

    public function setId($earn_id);

    public function getName();

    public function setName($earn_name);

    public function getDescription();

    public function setDescription($earn_description);

    public function getPoint();

    public function setPoint($earn_point);

    public function getStart();

    public function setStart($earn_start);

    public function getEnd();

    public function setEnd($earn_end);
    
    public function getActive();

    public function setActive($earn_actived);

    public function getGoalId();

    public function setGoalId($goal_id);

    public function getPriority();

    public function setPriority($earn_priority);

    public function getOverlap();

    public function setOverlap($earn_overlap);

}
