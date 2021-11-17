<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Column tooltip image display
 */
class TooltipImage extends Column
{
    const URL_PATH_EDIT = 'lenssystem/options/edit';
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var \Bss\LensSystem\Model\LensOptionsRepository
     */
    protected $lensOptionsRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     * @param \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->lensOptionsRepository = $lensOptionsRepository;
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        if (isset($dataSource['data']['items'])) {
            $fieldName = 'tooltip_image';
            foreach ($dataSource['data']['items'] as & $item) {
                $lensOption = $this->lensOptionsRepository->getById($item['entity_id']);
                if (isset($lensOption['tooltip_image'])) {
                    $name = $lensOption['tooltip_image'];
                    $item[$fieldName . '_src'] = $mediaUrl . 'bss/lenssystem/tooltipimage/' . $name;
                    $item[$fieldName . '_alt'] = '';
                    $item[$fieldName . '_link'] = $this->url->getUrl(static::URL_PATH_EDIT, [
                        'entity_id' => $item['entity_id']
                    ]);
                    $item[$fieldName . '_orig_src'] = $mediaUrl . 'bss/lenssystem/tooltipimage/' . $name;
                }
            }
        }
        return $dataSource;
    }
}
