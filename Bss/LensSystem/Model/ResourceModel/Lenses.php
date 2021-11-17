<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Lenses
 * ResourceModel Lenses
 */
class Lenses extends AbstractDb
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('lenssystem_lenses', 'id');
    }
}
