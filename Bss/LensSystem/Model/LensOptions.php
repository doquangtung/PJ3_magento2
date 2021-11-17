<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class LensOptions
 * Lens Options Model
 */
class LensOptions extends AbstractModel implements IdentityInterface, \Bss\LensSystem\Api\Data\LensOptionsInterface
{
    const CACHE_TAG = 'lenssystem_options';

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
    protected $cacheTag = 'lenssystem_options';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'lenssystem_options';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Bss\LensSystem\Model\ResourceModel\LensOptions::class);
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
    public function getOptionId()
    {
        return $this->getData('option_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setOptionId($value)
    {
        return $this->setData('option_id', $value);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTitle($value)
    {
        return $this->setData('title', $value);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setDescription($value)
    {
        return $this->setData('description', $value);
    }

    /**
     * @return mixed
     */
    public function getDescriptionShort()
    {
        return $this->getData('description_short');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setDescriptionShort($value)
    {
        return $this->setData('description_short', $value);
    }

    /**
     * @return mixed
     */
    public function getTooltipTitle()
    {
        return $this->getData('tooltip_title');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTooltipTitle($value)
    {
        return $this->setData('tooltip_title', $value);
    }

    /**
     * @return mixed
     */
    public function getTooltipImage()
    {
        return $this->getData('tooltip_image');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTooltipImage($value)
    {
        return $this->setData('tooltip_image', $value);
    }

    /**
     * @return mixed
     */
    public function getTooltipBody()
    {
        return $this->getData('tooltip_body');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTooltipBody($value)
    {
        return $this->setData('tooltip_body', $value);
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->getData('image');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setImage($value)
    {
        return $this->setData('image', $value);
    }

    /**
     * @return mixed
     */
    public function getImageRevert()
    {
        return $this->getData('image_revert');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setImageRevert($value)
    {
        return $this->setData('image_revert', $value);
    }

    /**
     * @return mixed
     */
    public function getOverlayImage()
    {
        return $this->getData('overlay_image');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setOverlayImage($value)
    {
        return $this->setData('overlay_image', $value);
    }
}
