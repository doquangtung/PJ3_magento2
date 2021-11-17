<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

interface FittingHeightInterface
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
    public function getLensType();

    /**
     * @param $lensType
     * @return mixed
     */
    public function setLensType($lensType);

    /**
     * @return mixed
     */
    public function getLensHeight();

    /**
     * @param $lensHeight
     * @return mixed
     */
    public function setLensHeight($lensHeight);

    /**
     * @return mixed
     */
    public function getFittingHeight();

    /**
     * @param $fittingHeight
     * @return mixed
     */
    public function setFittingHeight($fittingHeight);
}
