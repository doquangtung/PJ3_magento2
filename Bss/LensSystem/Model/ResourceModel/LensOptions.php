<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel;

use Bss\LensSystem\Setup\LensOptionsSetup;
use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Context;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class LensOptions
 * ResourceModel LensOptions
 */
class LensOptions extends AbstractEntity
{
    /**
     * Store id
     *
     * @var int
     */
    protected $storeId = null;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @param Context               $context
     * @param StoreManagerInterface $storeManager
     * @param array                 $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setType(LensOptionsSetup::ENTITY_TYPE_CODE);
        $this->setConnection(LensOptionsSetup::ENTITY_TYPE_CODE . '_read');
        $this->storeManager = $storeManager;
    }
    /**
     * Set attribute set id and entity type id value
     *
     * @param \Magento\Framework\DataObject $customer
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _beforeSave(\Magento\Framework\DataObject $object)
    {
        $object->setAttributeSetId($object->getAttributeSetId() ?: $this->getEntityType()->getDefaultAttributeSetId());
        $object->setEntityTypeId($object->getEntityTypeId() ?: $this->getEntityType()->getEntityTypeId());
        return parent::_beforeSave($object);
    }
    /**
     * Return Entity Type instance
     *
     * @return \Magento\Eav\Model\Entity\Type
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(LensOptionsSetup::ENTITY_TYPE_CODE);
        }
        return parent::getEntityType();
    }

    /**
     * @return string[]
     */
    protected function _getDefaultAttributes()
    {
        return [
            'attribute_set_id',
            'entity_type_id',
            'created_at',
            'updated_at',
        ];
    }
    /**
     * Set store Id
     *
     * @param integer $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        return $this;
    }
    /**
     * Return store id
     *
     * @return integer
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            return $this->storeManager->getStore()->getId();
        }
        return $this->storeId;
    }
    /**
     * Set Attribute values to be saved
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute
     * @param mixed $value
     * @return $this
     */
    protected function _saveAttribute($object, $attribute, $value)
    {
        $table = $attribute->getBackend()->getTable();
        if (!isset($this->_attributeValuesToSave[$table])) {
            $this->_attributeValuesToSave[$table] = [];
        }
        $entityIdField = $attribute->getBackend()->getEntityIdField();
        $storeId = $object->getStoreId() ?: Store::DEFAULT_STORE_ID;
        $data = [
            $entityIdField => $object->getId(),
            'entity_type_id' => $object->getEntityTypeId(),
            'attribute_id' => $attribute->getId(),
            'value' => $this->_prepareValueForSave($value, $attribute),
            'store_id' => $storeId,
        ];
        if (!$this->getEntityTable() || $this->getEntityTable() == \Magento\Eav\Model\Entity::DEFAULT_ENTITY_TABLE) {
            $data['entity_type_id'] = $object->getEntityTypeId();
        }
        if ($attribute->isScopeStore()) {
            /**
             * Update attribute value for store
             */
            $this->_attributeValuesToSave[$table][] = $data;
        } elseif ($attribute->isScopeWebsite() && $storeId != Store::DEFAULT_STORE_ID) {
            /**
             * Update attribute value for website
             */
            $storeIds = $this->storeManager->getStore($storeId)->getWebsite()->getStoreIds(true);
            foreach ($storeIds as $storeId) {
                $data['store_id'] = (int) $storeId;
                $this->_attributeValuesToSave[$table][] = $data;
            }
        } else {
            /**
             * Update global attribute value
             */
            $data['store_id'] = Store::DEFAULT_STORE_ID;
            $this->_attributeValuesToSave[$table][] = $data;
        }
        return $this;
    }
}
