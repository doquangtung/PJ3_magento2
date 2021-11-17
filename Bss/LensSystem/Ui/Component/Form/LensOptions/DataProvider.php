<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Form\LensOptions;

use Bss\LensSystem\Model\ResourceModel\LensOptions\Collection;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * DataProvider Class
 * Data Provider For Lens Options
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var FilterPool
     */
    protected $filterPool;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * @param string           $name             [description]
     * @param string           $primaryFieldName [description]
     * @param string           $requestFieldName [description]
     * @param Collection       $collection       [description]
     * @param FilterPool       $filterPool       [description]
     * @param RequestInterface $request          [description]
     * @param array            $meta             [description]
     * @param array            $data             [description]
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
        RequestInterface $request,
        \Magento\Store\Model\StoreManager $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
        $this->request = $request;
        $this->storeManager = $storeManager;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if (!$this->loadedData) {
            $storeId = (int) $this->request->getParam('store');
            $this->collection->setStoreId($storeId)->addAttributeToSelect('*');
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $item->setStoreId($storeId);
                $this->loadedData[$item->getEntityId()] = $item->getData();
                if (isset($this->loadedData[$item->getEntityId()]['tooltip_image'])) {
                    $tooltipimage = $this->loadedData[$item->getEntityId()]['tooltip_image'];
                    unset($this->loadedData[$item->getEntityId()]['tooltip_image']);
                    $this->loadedData[$item->getEntityId()]['tooltip_image'][0] = [
                        'name' => $tooltipimage,
                        'url' => $mediaUrl . 'bss/lenssystem/tooltipimage/' . $tooltipimage
                    ];
                }
                if (isset($this->loadedData[$item->getEntityId()]['image'])) {
                    $image = $this->loadedData[$item->getEntityId()]['image'];
                    unset($this->loadedData[$item->getEntityId()]['image']);
                    $this->loadedData[$item->getEntityId()]['image'][0] = [
                        'name' => $image,
                        'url' => $mediaUrl . 'bss/lenssystem/tooltipimage/' . $image
                    ];
                }
                if (isset($this->loadedData[$item->getEntityId()]['image_revert'])) {
                    $imgRevert = $this->loadedData[$item->getEntityId()]['image_revert'];
                    unset($this->loadedData[$item->getEntityId()]['image_revert']);
                    $this->loadedData[$item->getEntityId()]['image_revert'][0] = [
                        'name' => $imgRevert,
                        'url' => $mediaUrl . 'bss/lenssystem/tooltipimage/' . $imgRevert
                    ];
                }
                break;
            }
        }
        return $this->loadedData;
    }
}
