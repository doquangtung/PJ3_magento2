<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class LensCondition
 * LensCondition Model
 */
class LensCondition extends AbstractModel implements IdentityInterface, \Bss\LensSystem\Api\Data\LensConditionInterface
{
    const CACHE_TAG = 'lenssystem_condition';

    /**
     * entity_type_id for save Entity Type ID value
     */
    const KEY_ENTITY_TYPE_ID = 'entity_type_id';

    /**
     * attribute_set_id for save Attribute Set ID value
     */
    const KEY_ATTR_TYPE_ID = 'attribute_set_id';

    /**
     * @var string
     */
    protected $_cacheTag = 'lenssystem_condition';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'lenssystem_condition';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Bss\LensSystem\Model\ResourceModel\LensCondition::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Set attribute set entity type id
     *
     * @param int $entityTypeId
     * @return $this
     */
    public function setEntityTypeId($entityTypeId)
    {
        return $this->setData(self::KEY_ENTITY_TYPE_ID, $entityTypeId);
    }

    /**
     * @return array|mixed|null
     */
    public function getEntityTypeId()
    {
        return $this->getData(self::KEY_ENTITY_TYPE_ID);
    }

    /**
     * Set attribute set id
     *
     * @param int $attrSetId
     * @return $this
     */
    public function setAttributeSetId($attrSetId)
    {
        return $this->setData(self::KEY_ATTR_TYPE_ID, $attrSetId);
    }

    /**
     * @return array|mixed|null
     */
    public function getAttributeSetId()
    {
        return $this->getData(self::KEY_ATTR_TYPE_ID);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData('entity_id');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->setData('entity_id', $id);
    }

    /**
     * @return array|mixed|null
     */
    public function getTitle()
    {
        return $this->getData('condition_title');
    }

    /**
     * @param $value
     * @return LensCondition
     */
    public function setTitle($value)
    {
        return $this->setData('condition_title', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getMode()
    {
        return $this->getData('condition_mode');
    }

    /**
     * @param $value
     * @return LensCondition
     */
    public function setMode($value)
    {
        return $this->setData('condition_mode', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getValue()
    {
        return $this->getData('condition_value');
    }

    /**
     * @param $value
     * @return LensCondition
     */
    public function setValue($value)
    {
        return $this->setData('condition_value', $value);
    }
}
