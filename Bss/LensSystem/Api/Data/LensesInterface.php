<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

interface LensesInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getActive();

    /**
     * @param $value
     * @return mixed
     */
    public function setActive($value);

    /**
     * @return mixed
     */
    public function getSerial();

    /**
     * @param $value
     * @return mixed
     */
    public function setSerial($value);

    /**
     * @return mixed
     */
    public function getEyewearType();

    /**
     * @param $value
     * @return mixed
     */
    public function setEyewearType($value);

    /**
     * @return mixed
     */
    public function getLensType();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensType($value);

    /**
     * @return mixed
     */
    public function getLensFunc();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensFunc($value);

    /**
     * @return mixed
     */
    public function getLensPkg();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensPkg($value);

    /**
     * @return mixed
     */
    public function getLensColor();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensColor($value);

    /**
     * @return mixed
     */
    public function getSelectedUpgradeOptions();

    /**
     * @param $value
     * @return mixed
     */
    public function setSelectedUpgradeOptions($value);

    /**
     * @return mixed
     */
    public function getLensIndex();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensIndex($value);

    /**
     * @return mixed
     */
    public function getLensGroup();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensGroup($value);

    /**
     * @return mixed
     */
    public function getLensCode();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensCode($value);

    /**
     * @return mixed
     */
    public function getCoatingName();

    /**
     * @param $value
     * @return mixed
     */
    public function setCoatingName($value);

    /**
     * @return mixed
     */
    public function getCoatingCode();

    /**
     * @param $value
     * @return mixed
     */
    public function setCoatingCode($value);

    /**
     * @return mixed
     */
    public function getTintColorCode();

    /**
     * @param $value
     * @return mixed
     */
    public function setTintColorCode($value);

    /**
     * @return mixed
     */
    public function getLensAbsorption();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensAbsorption($value);

    /**
     * @return mixed
     */
    public function getLensDiameter();

    /**
     * @param $value
     * @return mixed
     */
    public function setLensDiameter($value);

    /**
     * @return mixed
     */
    public function getAvailableDiameter();

    /**
     * @param $value
     * @return mixed
     */
    public function setAvailableDiameter($value);

    /**
     * @return mixed
     */
    public function getPowerMinusLower();

    /**
     * @param $value
     * @return mixed
     */
    public function setPowerMinusLower($value);

    /**
     * @return mixed
     */
    public function getPowerMinusHigher();

    /**
     * @param $value
     * @return mixed
     */
    public function setPowerMinusHigher($value);

    /**
     * @return mixed
     */
    public function getPowerPlusHigher();

    /**
     * @param $value
     * @return mixed
     */
    public function setPowerPlusHigher($value);

    /**
     * @return mixed
     */
    public function getPowerPlusLower();

    /**
     * @param $value
     * @return mixed
     */
    public function setPowerPlusLower($value);

    /**
     * @return mixed
     */
    public function getCylMinusLower();

    /**
     * @param $value
     * @return mixed
     */
    public function setCylMinusLower($value);

    /**
     * @return mixed
     */
    public function getCylPlusLower();

    /**
     * @param $value
     * @return mixed
     */
    public function setCylPlusLower($value);

    /**
     * @return mixed
     */
    public function getCylPlusHigher();

    /**
     * @param $value
     * @return mixed
     */
    public function setCylPlusHigher($value);

    /**
     * @return mixed
     */
    public function getCylMinusHigher();

    /**
     * @param $value
     * @return mixed
     */
    public function setCylMinusHigher($value);

    /**
     * @return mixed
     */
    public function getAddMax();

    /**
     * @param $value
     * @return mixed
     */
    public function setAddMax($value);

    /**
     * @return mixed
     */
    public function getAddMin();

    /**
     * @param $value
     * @return mixed
     */
    public function setAddMin($value);
}
