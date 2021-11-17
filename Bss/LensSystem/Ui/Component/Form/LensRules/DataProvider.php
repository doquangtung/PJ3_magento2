<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Form\LensRules;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Bss\LensSystem\Model\ResourceModel\LensRule\CollectionFactory;

/**
 * Data provider for lens rules
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $this->loadedData[$this->collection->getFirstItem()->getId()] = $this->collection->getFirstItem()->getData();

        return $this->loadedData;
    }
}
