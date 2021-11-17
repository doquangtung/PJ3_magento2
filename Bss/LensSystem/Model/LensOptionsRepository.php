<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensOptionsInterface;
use Bss\LensSystem\Api\Data\LensOptionsSearchResultsInterface;
use Bss\LensSystem\Api\Data\LensOptionsSearchResultsInterfaceFactory;
use Bss\LensSystem\Api\LensOptionsRepositoryInterface;
use Bss\LensSystem\Model\ResourceModel\LensOptions as LensOptionsResource;
use Bss\LensSystem\Model\ResourceModel\LensOptions\CollectionFactory as LensOptionsCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * LensOptionsRepository Class
 * Action with model
 */
class LensOptionsRepository implements LensOptionsRepositoryInterface
{
    /**
     * @var LensOptionsResource
     */
    protected $resource;

    /**
     * @var LensOptionsSearchResultsInterface
     */
    private $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var array
     */
    protected $instance = [];

    /**
     * @var LensOptionsFactory
     */
    protected $lensOptionsFactory;

    /**
     * @var LensOptionsCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param LensOptionsResource $resource
     * @param LensOptionsFactory $lensOptionsFactory
     * @param LensOptionsSearchResultsInterfaceFactory $searchResultFactory
     * @param LensOptionsCollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        LensOptionsResource $resource,
        \Bss\LensSystem\Model\LensOptionsFactory $lensOptionsFactory,
        LensOptionsSearchResultsInterfaceFactory $searchResultFactory,
        LensOptionsCollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->lensOptionsFactory = $lensOptionsFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param LensOptionsInterface $options
     * @return LensOptionsInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(LensOptionsInterface $options)
    {
        $this->resource->save($options);
        return $options;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $options = $this->lensOptionsFactory->create();
        $this->resource->load($options, $id);
        if (!$options->getId()) {
            throw new NoSuchEntityException(__('Unable to find lensStep with ID "%1"', $id));
        }
        return $options;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param LensOptionsInterface $options
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(LensOptionsInterface $options)
    {
        return $this->resource->delete($options);
    }
}
