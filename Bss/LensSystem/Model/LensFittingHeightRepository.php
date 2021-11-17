<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\FittingHeightInterface;
use Bss\LensSystem\Api\Data\FittingHeightSearchResultsInterface;
use Bss\LensSystem\Api\Data\FittingHeightSearchResultsInterfaceFactory;
use Bss\LensSystem\Api\FittingHeightRepositoryInterface;
use Bss\LensSystem\Model\ResourceModel\LensFittingHeight as LensFittingHeightResource;
use Bss\LensSystem\Model\ResourceModel\LensFittingHeight\CollectionFactory as FittingHeightCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * LensFittingHeightRepository Class
 * Action with model
 */
class LensFittingHeightRepository implements FittingHeightRepositoryInterface
{
    /**
     * @var LensFittingHeightResource
     */
    protected $resource;

    /**
     * @var FittingHeightSearchResultsInterface
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
     * @var LensFittingHeightFactory
     */
    protected $lensFittingHeightFactory;

    /**
     * @var FittingHeightCollectionFactory
     */
    protected $lensFittingHeightCollectionFactory;

    /**
     * @param LensFittingHeightResource $resource
     * @param LensFittingHeightFactory $lensFittingHeightFactory
     * @param FittingHeightCollectionFactory $lensFittingHeightCollectionFactory
     * @param FittingHeightSearchResultsInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        LensFittingHeightResource $resource,
        \Bss\LensSystem\Model\LensFittingHeightFactory $lensFittingHeightFactory,
        FittingHeightSearchResultsInterfaceFactory $searchResultFactory,
        FittingHeightCollectionFactory $lensFittingHeightCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->lensFittingHeightFactory = $lensFittingHeightFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->lensFittingHeightCollectionFactory = $lensFittingHeightCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param FittingHeightInterface $fittingHeight
     * @return FittingHeightInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(FittingHeightInterface $fittingHeight)
    {
        $this->resource->save($fittingHeight);
        return $fittingHeight;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $fittingHeight = $this->lensFittingHeightFactory->create();
        $this->resource->load($fittingHeight, $id);
        if (!$fittingHeight->getId()) {
            throw new NoSuchEntityException(__('Unable to find fitting height with ID "%1"', $id));
        }
        return $fittingHeight;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->lensFittingHeightCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param FittingHeightInterface $fittingHeight
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(FittingHeightInterface $fittingHeight)
    {
        return $this->resource->delete($fittingHeight);
    }
}
