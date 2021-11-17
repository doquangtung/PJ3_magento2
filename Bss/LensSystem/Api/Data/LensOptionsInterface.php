<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

interface LensOptionsInterface
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
    public function getOptionId();

    /**
     * @param $value
     * @return mixed
     */
    public function setOptionId($value);

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
    public function getDescription();

    /**
     * @param $value
     * @return mixed
     */
    public function setDescription($value);

    /**
     * @return mixed
     */
    public function getDescriptionShort();

    /**
     * @param $value
     * @return mixed
     */
    public function setDescriptionShort($value);

    /**
     * @return mixed
     */
    public function getTooltipTitle();

    /**
     * @param $value
     * @return mixed
     */
    public function setTooltipTitle($value);

    /**
     * @return mixed
     */
    public function getTooltipImage();

    /**
     * @param $value
     * @return mixed
     */
    public function setTooltipImage($value);

    /**
     * @return mixed
     */
    public function getTooltipBody();

    /**
     * @param $value
     * @return mixed
     */
    public function setTooltipBody($value);

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @param $value
     * @return mixed
     */
    public function setImage($value);

    /**
     * @return mixed
     */
    public function getImageRevert();

    /**
     * @param $value
     * @return mixed
     */
    public function setImageRevert($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setOverlayImage($value);

    /**
     * @return mixed
     */
    public function getOverlayImage();
}
