<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\Eav;

use Bss\LensSystem\Setup\LensConditionSetup;
use Magento\Eav\Model\Entity\Attribute as EavAttribute;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

/**
 * Class ConditionAttribute
 * ResourceModel Condition Eav Attribute
 */
class ConditionAttribute extends EavAttribute implements ScopedAttributeInterface
{
    const MODULE_NAME = 'Bss_LensSystem';
    const KEY_IS_GLOBAL = 'is_global';
    const KEY_IS_STATIC = 'static';

    /**
     * @var string
     */
    protected $_eventObject = 'attribute';

    /**
     * @var null
     */
    protected static $_labels = null;

    /**
     * @var string
     */
    protected $_eventPrefix = LensConditionSetup::ENTITY_TYPE_CODE . '_attribute';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Bss\LensSystem\Model\ResourceModel\Attribute::class);
    }

    /**
     * @return ConditionAttribute
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $this->setData('modulePrefix', self::MODULE_NAME);
        if (isset($this->_origData[self::KEY_IS_GLOBAL])) {
            if (!isset($this->_data[self::KEY_IS_GLOBAL])) {
                $this->_data[self::KEY_IS_GLOBAL] = self::SCOPE_GLOBAL;
            }
        }
        return parent::beforeSave();
    }

    /**
     * Processing object after save data
     *
     * @return AbstractModel
     * @throws LocalizedException
     */
    public function afterSave()
    {
        $this->_eavConfig->clear();
        return parent::afterSave();
    }

    /**
     * Return is attribute global
     *
     * @return integer
     */
    public function getIsGlobal()
    {
        if ($this->getBackendType() === self::KEY_IS_STATIC) {
            return true;
        }
        return $this->_getData(self::KEY_IS_GLOBAL);
    }

    /**
     * Retrieve attribute is global scope flag
     *
     * @return bool
     */
    public function isScopeGlobal()
    {
        return $this->getIsGlobal() == self::SCOPE_GLOBAL;
    }

    /**
     * Retrieve attribute is website scope website
     *
     * @return bool
     */
    public function isScopeWebsite()
    {
        return $this->getIsGlobal() == self::SCOPE_WEBSITE;
    }

    /**
     * Retrieve attribute is store scope flag
     *
     * @return bool
     */
    public function isScopeStore()
    {
        return !$this->isScopeGlobal() && !$this->isScopeWebsite();
    }

    /**
     * Retrieve store id
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->getData('store_id');
    }

    /**
     * Retrieve source model
     *
     * @return AbstractSource
     */
    public function getSourceModel()
    {
        $model = $this->getData('source_model');
        if (empty($model)) {
            if ($this->getBackendType() == 'int' && $this->getFrontendInput() == 'select') {
                return $this->_getDefaultSourceModel();
            }
        }
        return $model;
    }

    /**
     * Get default attribute source model
     *
     * @return string
     */
    public function _getDefaultSourceModel()
    {
        return \Magento\Eav\Model\Entity\Attribute\Source\Table::class;
    }

    /**
     * @return Attribute
     */
    public function afterDelete()
    {
        $this->_eavConfig->clear();
        return parent::afterDelete();
    }
}
