<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\Lenses;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * ResourceModel Lenses Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Constructor init
     */
    protected function _construct()
    {
        $this->_init(
            \Bss\LensSystem\Model\Lenses::class,
            \Bss\LensSystem\Model\ResourceModel\Lenses::class
        );
    }
}
