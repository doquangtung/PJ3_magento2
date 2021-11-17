<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensesInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Lenses
 * Lenses Model
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class Lenses extends AbstractModel implements LensesInterface, IdentityInterface
{
    const CACHE_TAG = 'Bss_LensSystem';

    /**
     * @var string
     */
    protected $cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $eventPrefix = self::CACHE_TAG;

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(\Bss\LensSystem\Model\ResourceModel\Lenses::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * @param mixed $id
     * @return LensFittingHeight|mixed
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * @return array|mixed|null
     */
    public function getActive()
    {
        return $this->getData('active');
    }

    /**
     * @param $value
     * @return mixed|void
     */
    public function setActive($value)
    {
        return $this->setData('active', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getSerial()
    {
        return $this->getData('serial');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setSerial($value)
    {
        return $this->setData('serial', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getEyewearType()
    {
        return $this->getData('eyewear_type');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setEyewearType($value)
    {
        return $this->setData('eyewear_type', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensType()
    {
        return $this->getData('lens_type');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensType($value)
    {
        return $this->setData('id', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensFunc()
    {
        return $this->getData('lens_func');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensFunc($value)
    {
        return $this->setData('lens_func', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensPkg()
    {
        return $this->getData('lens_pkg');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensPkg($value)
    {
        return $this->setData('lens_pkg', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensColor()
    {
        return $this->getData('lens_color');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensColor($value)
    {
        return $this->setData('lens_color', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getSelectedUpgradeOptions()
    {
        return $this->getData('selected_upgrade_options');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setSelectedUpgradeOptions($value)
    {
        return $this->setData('selected_upgrade_options', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensIndex()
    {
        return $this->getData('lens_index');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensIndex($value)
    {
        return $this->setData('lens_index', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensGroup()
    {
        return $this->getData('lens_group');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensGroup($value)
    {
        return $this->setData('lens_group', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensCode()
    {
        return $this->getData('lens_code');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensCode($value)
    {
        return $this->setData('lens_code', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getCoatingName()
    {
        return $this->getData('coating_name');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setCoatingName($value)
    {
        return $this->setData('coating_name', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getCoatingCode()
    {
        return $this->getData('coating_code');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setCoatingCode($value)
    {
        return $this->setData('coating_code', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getTintColorCode()
    {
        return $this->getData('tint_color_code');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setTintColorCode($value)
    {
        return $this->setData('tint_color_code', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensAbsorption()
    {
        return $this->getData('lens_absorption');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensAbsorption($value)
    {
        return $this->setData('lens_absorption', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensDiameter()
    {
        return $this->getData('lens_diameter');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setLensDiameter($value)
    {
        return $this->setData('lens_diameter', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getAvailableDiameter()
    {
        return $this->getData('available_diameter');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setAvailableDiameter($value)
    {
        return $this->setData('available_diameter', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getPowerMinusLower()
    {
        return $this->getData('power_minus_lower');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setPowerMinusLower($value)
    {
        return $this->setData('power_minus_lower', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getPowerMinusHigher()
    {
        return $this->getData('power_minus_higher');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setPowerMinusHigher($value)
    {
        return $this->setData('power_minus_higher', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getPowerPlusHigher()
    {
        return $this->getData('power_plus_higher');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setPowerPlusHigher($value)
    {
        return $this->setData('power_plus_higher', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getPowerPlusLower()
    {
        return $this->getData('power_plus_lower');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setPowerPlusLower($value)
    {
        return $this->setData('power_plus_lower', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getCylMinusLower()
    {
        return $this->getData('cyl_minus_lower');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setCylMinusLower($value)
    {
        return $this->setData('cyl_minus_lower', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getCylPlusLower()
    {
        return $this->getData('cyl_plus_lower');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setCylPlusLower($value)
    {
        return $this->setData('cyl_plus_lower', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getCylPlusHigher()
    {
        return $this->getData('cyl_plus_higher');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setCylPlusHigher($value)
    {
        return $this->setData('cyl_plus_higher', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getCylMinusHigher()
    {
        return $this->getData('cyl_minus_higher');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setCylMinusHigher($value)
    {
        return $this->setData('cyl_minus_higher', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getAddMax()
    {
        return $this->getData('add_max');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setAddMax($value)
    {
        return $this->setData('add_max', $value);
    }

    /**
     * @return array|mixed|null
     */
    public function getAddMin()
    {
        return $this->getData('add_min');
    }

    /**
     * @param $value
     * @return Lenses|mixed
     */
    public function setAddMin($value)
    {
        return $this->setData('add_min', $value);
    }
}
