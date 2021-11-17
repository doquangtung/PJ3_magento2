<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

interface LensDiscountInterface
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
    public function getName();

    /**
     * @param $value
     * @return mixed
     */
    public function setName($value);

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @param $value
     * @return mixed
     */
    public function setDescription($value);

    /**
     * @return mixed
     */
    public function getFromDate();

    /**
     * @param $value
     * @return mixed
     */
    public function setFromDate($value);

    /**
     * @return mixed
     */
    public function getToDate();

    /**
     * @param $value
     * @return mixed
     */
    public function setToDate($value);

    /**
     * @return mixed
     */
    public function getIsActive();

    /**
     * @param $value
     * @return mixed
     */
    public function setIsActive($value);

    /**
     * @return mixed
     */
    public function getRule();

    /**
     * @param $value
     * @return mixed
     */
    public function setRule($value);

    /**
     * @return mixed
     */
    public function getSortOrder();

    /**
     * @param $value
     * @return mixed
     */
    public function setSortOrder($value);
}
