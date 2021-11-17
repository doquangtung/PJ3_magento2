<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\LensSteps;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Eav\Model\EntityFactory as EavEntityFactory;
use Magento\Eav\Model\ResourceModel\Helper;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Validator\UniversalFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 * LensStep Collection
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $idFieldName = 'entity_id';

    /**
     * @var $_storeId
     */
    protected $storeId;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param EntityFactory          $entityFactory
     * @param LoggerInterface        $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface       $eventManager
     * @param Config                 $eavConfig
     * @param ResourceConnection     $resource
     * @param EavEntityFactory       $eavEntityFactory
     * @param Helper                 $resourceHelper
     * @param UniversalFactory       $universalFactory
     * @param StoreManagerInterface  $storeManager
     * @param AdapterInterface|null  $connection
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        EntityFactory $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Config $eavConfig,
        ResourceConnection $resource,
        EavEntityFactory $eavEntityFactory,
        Helper $resourceHelper,
        UniversalFactory $universalFactory,
        StoreManagerInterface $storeManager,
        AdapterInterface $connection = null
    ) {
        $this->storeManager = $storeManager;
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $eavConfig,
            $resource,
            $eavEntityFactory,
            $resourceHelper,
            $universalFactory,
            $connection
        );
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Bss\LensSystem\Model\LensSteps::class, \Bss\LensSystem\Model\ResourceModel\LensSteps::class);
    }

    /**
     * Set store scope
     *
     * @param int|string|\Magento\Store\Model\Store $store
     * @return $this
     */
    public function setStore($store)
    {
        $this->setStoreId($this->storeManager->getStore($store)->getId());
        return $this;
    }

    /**
     * Set store scope
     *
     * @param int|string|\Magento\Store\Api\Data\StoreInterface $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        if ($storeId instanceof \Magento\Store\Api\Data\StoreInterface) {
            $storeId = $storeId->getId();
        }
        $this->storeId = (int) $storeId;
        return $this;
    }

    /**
     * Return current store id
     *
     * @return int
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            $this->setStoreId($this->storeManager->getStore()->getId());
        }
        return $this->storeId;
    }

    /**
     * Retrieve default store id
     *
     * @return int
     */
    public function getDefaultStoreId()
    {
        return \Magento\Store\Model\Store::DEFAULT_STORE_ID;
    }

    /**
     * Retrieve attributes load select
     *
     * @param string $table
     * @param array|int $attributeIds
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection
     */
    protected function _getLoadAttributesSelect($table, $attributeIds = [])
    {
        if (empty($attributeIds)) {
            $attributeIds = $this->_selectAttributes;
        }
        $storeId = $this->getStoreId();
        $connection = $this->getConnection();
        $entityTable = $this->getEntity()->getEntityTable();
        $indexList = $connection->getIndexList($entityTable);
        $entityIdField = $indexList[$connection->getPrimaryKeyName($entityTable)]['COLUMNS_LIST'][0];
        if ($storeId) {
            $joinCondition = [
                't_s.attribute_id = t_d.attribute_id',
                "t_s.{$entityIdField} = t_d.{$entityIdField}",
                $connection->quoteInto('t_s.store_id = ?', $storeId),
            ];
            $select = $connection->select()->from(
                ['t_d' => $table],
                ['attribute_id']
            )->join(
                ['e' => $entityTable],
                "e.{$entityIdField} = t_d.{$entityIdField}",
                ['e.entity_id']
            )->where(
                "e.entity_id IN (?)",
                array_keys($this->_itemsById)
            )->where(
                't_d.attribute_id IN (?)',
                $attributeIds
            )->joinLeft(
                ['t_s' => $table],
                implode(' AND ', $joinCondition),
                []
            )->where(
                't_d.store_id = ?',
                $connection->getIfNullSql('t_s.store_id', \Magento\Store\Model\Store::DEFAULT_STORE_ID)
            );
        } else {
            $select = $connection->select()->from(
                ['t_d' => $table],
                ['attribute_id']
            )->join(
                ['e' => $entityTable],
                "e.{$entityIdField} = t_d.{$entityIdField}",
                ['e.entity_id']
            )->where(
                "e.entity_id IN (?)",
                array_keys($this->_itemsById)
            )->where(
                'attribute_id IN (?)',
                $attributeIds
            )->where(
                'store_id = ?',
                $this->getDefaultStoreId()
            );
        }
        return $select;
    }

    /**
     * @param \Magento\Framework\DB\Select $select
     * @param string $table
     * @param string $type
     * @return \Magento\Framework\DB\Select
     */
    protected function _addLoadAttributesSelectValues($select, $table, $type)
    {
        $storeId = $this->getStoreId();
        if ($storeId) {
            $connection = $this->getConnection();
            $valueExpr = $connection->getCheckSql('t_s.value_id IS NULL', 't_d.value', 't_s.value');
            $select->columns(
                ['default_value' => 't_d.value', 'store_value' => 't_s.value', 'value' => $valueExpr]
            );
        } else {
            $select = parent::_addLoadAttributesSelectValues($select, $table, $type);
        }
        return $select;
    }

    /**
     * Adding join statement to collection select instance
     *
     * @param string $method
     * @param object $attribute
     * @param string $tableAlias
     * @param array $condition
     * @param string $fieldCode
     * @param string $fieldAlias
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection
     */
    protected function _joinAttributeToSelect($method, $attribute, $tableAlias, $condition, $fieldCode, $fieldAlias)
    {
        if (isset($this->_joinAttributes[$fieldCode]['store_id'])) {
            $storeId = $this->_joinAttributes[$fieldCode]['store_id'];
        } else {
            $storeId = $this->getStoreId();
        }
        $connection = $this->getConnection();
        if ($storeId != $this->getDefaultStoreId() && !$attribute->isScopeGlobal()) {
            $defCondition = '(' . implode(') AND (', $condition) . ')';
            $defAlias = $tableAlias . '_default';
            $defAlias = $this->getConnection()->getTableName($defAlias);
            $defFieldAlias = str_replace($tableAlias, $defAlias, $fieldAlias);
            $tableAlias = $this->getConnection()->getTableName($tableAlias);
            $defCondition = str_replace($tableAlias, $defAlias, $defCondition);
            $defCondition .= $connection->quoteInto(
                " AND " . $connection->quoteColumnAs("{$defAlias}.store_id", null) . " = ?",
                $this->getDefaultStoreId()
            );
            $this->getSelect()->{$method}(
                [$defAlias => $attribute->getBackend()->getTable()],
                $defCondition,
                []
            );
            $method = 'joinLeft';
            $fieldAlias = $this->getConnection()->getCheckSql(
                "{$tableAlias}.value_id > 0",
                $fieldAlias,
                $defFieldAlias
            );
            $this->_joinAttributes[$fieldCode]['condition_alias'] = $fieldAlias;
            $this->_joinAttributes[$fieldCode]['attribute'] = $attribute;
        } else {
            $storeId = $this->getDefaultStoreId();
        }
        $condition[] = $connection->quoteInto(
            $connection->quoteColumnAs("{$tableAlias}.store_id", null) . ' = ?',
            $storeId
        );
        return parent::_joinAttributeToSelect($method, $attribute, $tableAlias, $condition, $fieldCode, $fieldAlias);
    }
}
