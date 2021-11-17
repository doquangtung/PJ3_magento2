<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class LensFittingHeightActions
 * Actions for LensFittingHeight
 */
class LensFittingHeightActions extends Column
{
    const EDIT = 'lenssystem/fittingheight/edit';
    const DELETE = 'lenssystem/fittingheight/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var mixed|string
     */
    private $editUrl;

    /**
     * @var mixed|string
     */
    private $deleteUrl;

    /**
     * LensFittingHeightActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     * @param string $deleteUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::EDIT,
        $deleteUrl = self::DELETE
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->deleteUrl = $deleteUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl($this->deleteUrl, ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you want to delete record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
