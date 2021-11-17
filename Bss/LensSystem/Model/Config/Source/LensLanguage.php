<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class LensLanguage
 * List language for lens system
 */
class LensLanguage implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'en', 'label' => __('English')],
            ['value' => 'fr', 'label' => __('French')],
            ['value' => 'hk', 'label' => __('Hong Kong')],
            ['value' => 'de', 'label' => __('German')]
        ];
    }
}
