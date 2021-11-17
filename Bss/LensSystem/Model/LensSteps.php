<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class LensSteps
 * LensStep Model
 */
class LensSteps extends AbstractModel implements IdentityInterface, \Bss\LensSystem\Api\Data\LensStepInterface
{
    const CACHE_TAG = 'lenssystem_steps';

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
    protected $cacheTag = 'lenssystem_steps';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'lenssystem_steps';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Bss\LensSystem\Model\ResourceModel\LensSteps::class);
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
     * @return mixed
     */
    public function getStepId()
    {
        return $this->getData('step_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setStepId($value)
    {
        return $this->setData('step_id', $value);
    }

    /**
     * @return mixed
     */
    public function getStepTitle()
    {
        return $this->getData('step_title');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setStepTitle($value)
    {
        return $this->setData('step_title', $value);
    }

    /**
     * @return mixed
     */
    public function getInstru()
    {
        return $this->getData('instru');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setInstru($value)
    {
        return $this->setData('instru', $value);
    }

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->getData('layout');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setLayout($value)
    {
        return $this->setData('layout', $value);
    }
}
