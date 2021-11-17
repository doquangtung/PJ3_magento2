<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

interface LensConditionInterface
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
    public function getTitle();

    /**
     * @param $value
     * @return mixed
     */
    public function setTitle($value);

    /**
     * @return mixed
     */
    public function getMode();

    /**
     * @param $value
     * @return mixed
     */
    public function setMode($value);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return mixed
     */
    public function setValue($value);
}
