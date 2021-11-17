<?php
declare(strict_types=1);

namespace Bss\LensSystem\Block\Adminhtml\Options\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 * Delete selected entity_id
 */
class DeleteButton implements ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * DeleteButton constructor.
     * @param Context $context
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        RequestInterface $request
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = null;
        if ($this->request->getParam('entity_id') > 0) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'id' => 'lens-options-delete-button',
                'data_attribute' => [
                    'url' => $this->getDeleteUrl(),
                ],
                'on_click' => 'deleteConfirm(\'' . __("Are you sure you want to do this?") .
                    '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['entity_id' => $this->request->getParam('entity_id')]);
    }
}
