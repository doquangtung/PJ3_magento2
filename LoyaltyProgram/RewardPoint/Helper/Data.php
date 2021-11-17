<?php
namespace LoyaltyProgram\RewardPoint\Helper;
 
use LoyaltyProgram\RewardPoint\Model\GoalFactory;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $goalFactory;
    public function __construct(
        Context $context,
        \LoyaltyProgram\RewardPoint\Model\GoalFactory $goalFactory,
        array $data = array()
    )     {
        $this->goalFactory = $goalFactory;
        parent::__construct($context, $data);
    }
    public function getCollection()
    {
        return $this->goalFactory->create()->getCollection();
    }
}