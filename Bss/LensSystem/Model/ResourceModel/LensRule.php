<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Lens Rule Resource Model
 */
class LensRule extends AbstractDb
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('lens_rules', 'rule_id');
    }
}
