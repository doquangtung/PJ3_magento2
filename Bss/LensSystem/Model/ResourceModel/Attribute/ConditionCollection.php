<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\Attribute;

use Bss\LensSystem\Setup\LensConditionSetup;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Type;
use Magento\Eav\Model\EntityFactory as EavEntityFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as EavCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;

/**
 * Class ConditionCollection
 * Resource Model for Attribute Condition
 */
class ConditionCollection extends EavCollection
{
    /**
     * @var EavEntityFactory
     */
    protected $_eavEntityFactory;

    /**
     * ConditionCollection constructor.
     * @param EntityFactory $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param Config $eavConfig
     * @param EavEntityFactory $eavEntityFactory
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
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
        $this->_eavEntityFactory = $eavEntityFactory;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $connection, $resource);
    }

    /**
     * Main select object initialization.
     *
     * @return $this
     * @throws LocalizedException
     */
    protected function _initSelect()
    {
        $this->getSelect()->from(
            ['main_table' => $this->getResource()->getMainTable()]
        )->where(
            'main_table.entity_type_id=?',
            $this->_eavEntityFactory->create()->setType(LensConditionSetup::ENTITY_TYPE_CODE)->getTypeId()
        )->join(
            ['additional_table' => $this->getTable(LensConditionSetup::EAV_ENTITY_TYPE_CODE . '_eav_attribute')],
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
     * @param int|Type $typeId
     * @return $this|ConditionCollection
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setEntityTypeFilter($typeId)
    {
        return $this;
    }
}
