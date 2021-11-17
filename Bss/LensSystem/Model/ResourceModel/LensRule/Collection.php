<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\ResourceModel\LensRule;

use Bss\LensSystem\Model\LensRule as LensRuleModel;
use Bss\LensSystem\Model\ResourceModel\LensRule as LensRuleResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Lens rule collection
 */
class Collection extends AbstractCollection
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(
            LensRuleModel::class,
            LensRuleResourceModel::class
        );
    }
}
