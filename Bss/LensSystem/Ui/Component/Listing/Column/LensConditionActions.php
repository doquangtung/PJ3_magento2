<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class LensConditionActions
 * Action for lens condition
 */
class LensConditionActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'lenssystem/condition/edit';

    const URL_PATH_DELETE = 'lenssystem/condition/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * LensConditionActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_EDIT,
                            ['entity_id' => $item['entity_id'], 'store' => $storeId]
                        ),
                        'label' => __('Edit'),
                        'hidden' => false,
                    ];
                    $item[$this->getData('name')]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_DELETE,
                            ['entity_id' => $item['entity_id'], 'store' => $storeId]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ID ' . $item['entity_id']),
                            'message' => __('Are you sure you want to delete ID ' . $item['entity_id']),
                        ],
                        'hidden' => false,
                    ];
                }
            }
        }
        return $dataSource;
    }
}
