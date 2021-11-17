<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\LensFittingHeight;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * Lens Fitting Height Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(
            \Bss\LensSystem\Model\LensFittingHeight::class,
            \Bss\LensSystem\Model\ResourceModel\LensFittingHeight::class
        );
    }
}
