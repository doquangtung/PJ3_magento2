<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Api\BookmarkManagementInterface;
use Magento\Ui\Api\BookmarkRepositoryInterface;

/**
 * BookMark Class
 * Bookmark for Listing Colum
 */
class Bookmark extends \Magento\Ui\Component\Bookmark
{
    /**
     * @var \Bss\LensSystem\Model\LensOptions
     */
    protected $lensOptions;

    /**
     * Bookmark constructor.
     * @param ContextInterface $context
     * @param \Bss\LensSystem\Model\LensOptions $lensOptions
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkManagementInterface $bookmarkManagement
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        \Bss\LensSystem\Model\LensOptions $lensOptions,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkManagementInterface $bookmarkManagement,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $bookmarkRepository, $bookmarkManagement, $components, $data);
        $this->lensOptions = $lensOptions;
    }

    /**
     * Register component
     *
     * @return void
     */
    public function prepare()
    {
        $namespace = $this->getContext()->getRequestParam('namespace', $this->getContext()->getNamespace());
        $config = [];
        if (!empty($namespace)) {
            $storeId = $this->getContext()->getRequestParam('store');
            if (empty($storeId)) {
                $storeId = $this->getContext()->getFilterParam('store_id');
            }
            $bookmarks = $this->bookmarkManagement->loadByNamespace($namespace);
            /** @var \Magento\Ui\Api\Data\BookmarkInterface $bookmark */
            foreach ($bookmarks->getItems() as $bookmark) {
                if ($bookmark->isCurrent()) {
                    $config['activeIndex'] = $bookmark->getIdentifier();
                }
                $config = array_merge_recursive($config, $bookmark->getConfig());
                if (!empty($storeId)) {
                    $config['current']['filters']['applied']['store_id'] = $storeId;
                }
            }
        }
        $this->setData('config', array_replace_recursive($config, $this->getConfiguration()));
        parent::prepare();
        $jsConfig = $this->getConfiguration();
        $this->getContext()->addComponentDefinition($this->getComponentName(), $jsConfig);
    }
}
