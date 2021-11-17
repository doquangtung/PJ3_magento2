<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\FittingHeightInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class LensFittingHeight
 * Lens Fitting Height Model
 */
class LensFittingHeight extends AbstractModel implements FittingHeightInterface, IdentityInterface
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
     * Constructor init
     */
    protected function _construct()
    {
        $this->_init(\Bss\LensSystem\Model\ResourceModel\LensFittingHeight::class);
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
    public function getLensType()
    {
        return $this->getData('lens_type');
    }

    /**
     * @param $lensType
     * @return array|mixed|null
     */
    public function setLensType($lensType)
    {
        return $this->getData('lens_type', $lensType);
    }

    /**
     * @return array|mixed|null
     */
    public function getFittingHeight()
    {
        return $this->getData('fitting_height');
    }

    /**
     * @param $fittingHeight
     * @return array|mixed|null
     */
    public function setFittingHeight($fittingHeight)
    {
        return $this->getData('fitting_height', $fittingHeight);
    }

    /**
     * @return array|mixed|null
     */
    public function getLensHeight()
    {
        return $this->getData('lens_height');
    }

    /**
     * @param $lensHeight
     * @return array|mixed|null
     */
    public function setLensHeight($lensHeight)
    {
        return $this->getData('lens_height', $lensHeight);
    }
}
