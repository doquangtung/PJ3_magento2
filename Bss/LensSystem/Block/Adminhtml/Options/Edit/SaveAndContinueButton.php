<?php
declare(strict_types=1);

namespace Bss\LensSystem\Block\Adminhtml\Options\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Save And Continue
 * Action for Save and Continue Button
 */
class SaveAndContinueButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 50,
        ];
        return $data;
    }
}
