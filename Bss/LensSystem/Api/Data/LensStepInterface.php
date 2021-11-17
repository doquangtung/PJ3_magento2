<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

interface LensStepInterface
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
    public function getStepId();

    /**
     * @param $value
     * @return mixed
     */
    public function setStepId($value);

    /**
     * @return mixed
     */
    public function getStepTitle();

    /**
     * @param $value
     * @return mixed
     */
    public function setStepTitle($value);

    /**
     * @return mixed
     */
    public function getInstru();

    /**
     * @param $value
     * @return mixed
     */
    public function setInstru($value);

    /**
     * @return mixed
     */
    public function getLayout();

    /**
     * @param $value
     * @return mixed
     */
    public function setLayout($value);
}
