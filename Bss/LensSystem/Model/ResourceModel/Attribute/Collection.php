<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\Attribute;

use Bss\LensSystem\Setup\LensOptionsSetup;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\EntityFactory as EavEntityFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as EavCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;

/**
 * Collection for attribute
 * Attribute Resource Model
 */
class Collection extends EavCollection
{
    /**
     * Entity factory
     *
     * @var EavEntityFactory
     */
    protected $eavEntityFactory;

    /**
     * @param EntityFactory          $entityFactory
     * @param LoggerInterface        $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface       $eventManager
     * @param Config                 $eavConfig
     * @param EavEntityFactory       $eavEntityFactory
     * @param AdapterInterface|null  $connection
     * @param AbstractDb|null        $resource
     */
    public function __construct(
        EntityFactory $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Config $eavConfig,
        EavEntityFactory $eavEntityFactory,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->eavEntityFactory = $eavEntityFactory;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $connection, $resource);
    }

    /**
     * Main select object initialization.
     *
     * @return $this
     */
    protected function _initSelect()
    {
        $this->getSelect()->from(
            ['main_table' => $this->getResource()->getMainTable()]
        )->where(
            'main_table.entity_type_id=?',
            $this->eavEntityFactory->create()->setType(LensOptionsSetup::ENTITY_TYPE_CODE)->getTypeId()
        )->join(
            ['additional_table' => $this->getTable(LensOptionsSetup::EAV_ENTITY_TYPE_CODE . '_eav_attribute')],
            'additional_table.attribute_id = main_table.attribute_id'
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function getFilterAttributesOnly()
    {
        $this->getSelect()->where('additional_table.is_filterable', 1);
        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function addVisibilityFilter($status = 1)
    {
        $this->getSelect()->where('additional_table.is_visible', $status);
        return $this;
    }

    /**
     * Specify attribute entity type filter
     *
     * @param int $typeId
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setEntityTypeFilter($typeId)
    {
        return $this;
    }
}
