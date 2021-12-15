<?php
namespace LoyaltyProgram\RewardPoint\Observer;

use Magento\Framework\Event\ObserverInterface;

class OrderManage implements ObserverInterface
{      
  protected $_customerRepositoryInterface;

  public function __construct(
    \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
    \Magento\Framework\App\ResourceConnection $resourceConnection ,
    \Magento\Framework\Stdlib\DateTime\DateTime $date,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
) {
    $this->_customerRepositoryInterface = $customerRepositoryInterface;
    $this->resourceConnection = $resourceConnection;
    $this->date = $date;
	$this->timezone = $timezone;
}

 public function execute(\Magento\Framework\Event\Observer $observer)
 {
    $order = $observer->getEvent()->getOrder();
    $user = $order->getCustomerId();
    $date = $this->date->gmtDate();
	$date = $this->timezone->date(new \DateTime($date))->format('y/m/d H:i:s');
    
    if($order->getState() == 'complete') {
        $connection  = $this->resourceConnection->getConnection();
        $tableEarn = $connection->getTableName('earn'); //gives table name
        $tableProcess = $connection->getTableName('process');
        $tableGoal = $connection->getTableName('goal'); //gives table name
        $tablePoint = $connection->getTableName('current_point');
        $tableHistory = $connection->getTableName('history_point');
        
        $sqlEarn = $connection->select('*')->from($tableEarn)->join(
                $tableGoal, 
                $tableEarn . '.goal_id = ' . $tableGoal . '.goal_id'
            )->where($tableEarn . '.earn_actived = 1');
        
        foreach ($connection->fetchAll($sqlEarn) as $row){   
        if ($row['earn_id'] == 11) {
            $orderPoint = ($order->getGrandTotal() - $order->getShippingAmount())*$row['earn_point'];
            $sqlGetPoint = $connection->select('*')->from($tablePoint)->where(
                $tablePoint . '.entity_id = ' . $user
            );     
            foreach ($connection->fetchAll($sqlGetPoint) as $rowUser){   
            $userPoint = $rowUser['point'];
            }
            $dataPoint = [
                'point' => $userPoint + $orderPoint,
            ];
            $connection->update($tablePoint, $dataPoint, ['entity_id = ?' => $user]);
            $dataHistory = [
                'entity_id' => $user,
                'history_point' => $orderPoint,
                'earn_id' => 11,
                'history_date' => $date,
                'history_reason' => 'Get point from Order ' . $order->getEntityId(),
                'is_delete' => 0,
            ];
            $connection->insert($tableHistory, $dataHistory);
        } else if ($row['goal_type'] == "Order" || $row['goal_type'] == "USD") {
            $sqlProcess = $connection->select('*')->from($tableProcess)->where(
            $tableProcess . '.entity_id = ' . $user . ' AND ' . $tableProcess . '.earn_id = ' . $row['earn_id']);
            $result = $connection->fetchAll($sqlProcess);  
            if (count($result) == 0) {
                $dataProcess = [
                    'entity_id' => $user,
                    'earn_id' => $row['earn_id'],
                    'process_activity' => 0,
                ];
                $connection->insert($tableProcess, $dataProcess);
            }
            $sqlGetProcess = $connection->select('*')->from($tableProcess)->where(
            $tableProcess . '.entity_id = ' . $user . ' AND ' . $tableProcess . '.earn_id = ' . $row['earn_id']);
            foreach ($connection->fetchAll($sqlGetProcess) as $rowProcess){   
                $userProcess = $rowProcess['process_activity'];
                }
            if ($userProcess < $row['goal_number']){
                if ($row['goal_type'] == "Order") $type = 1;
                else $type = $order->getGrandTotal() - $order->getShippingAmount();
                if ($userProcess + $type >= $row['goal_number']){
                    $newProcess = $row['goal_number'];
                    
                    $sqlGetPoint = $connection->select('*')->from($tablePoint)->where(
                        $tablePoint . '.entity_id = ' . $user
                    );     
                    foreach ($connection->fetchAll($sqlGetPoint) as $rowUser){   
                    $userPoint = $rowUser['point'];
                    }
                    $dataPoint = [
                        'point' => $userPoint + $row['earn_point'],
                    ];
                    $connection->update($tablePoint, $dataPoint, ['entity_id = ?' => $user]);

                    $dataHistory = [
                        'entity_id' => $user,
                        'history_point' => $row['earn_point'],
                        'earn_id' => $row['earn_id'],
                        'history_date' => $date,
                        'history_reason' => 'Get point from Activity ' . $row['earn_id'],
                        'is_delete' => 0,
                    ];
                    $connection->insert($tableHistory, $dataHistory);
                } else $newProcess = $userProcess + $type;
                $dataProcess = [
                    'process_activity' => $newProcess,
                ];
                $connection->update($tableProcess, $dataProcess, ['entity_id = ?' => $user, 'earn_id = ?' => $row['earn_id']]);
            }
        }
        }
    }
  }
}