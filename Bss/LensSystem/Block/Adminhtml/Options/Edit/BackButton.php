<?php
declare(strict_types=1);

namespace Bss\LensSystem\Block\Adminhtml\Options\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Back Button
 * Generate BackButton Action
 */
class BackButton implements ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * BackButton constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->urlBuilder->getUrl('*/*/');
    }
}
