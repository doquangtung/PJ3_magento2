<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensesInterface;
use Bss\LensSystem\Api\Data\LensesSearchResultsInterface;
use Bss\LensSystem\Api\Data\LensesSearchResultsInterfaceFactory;
use Bss\LensSystem\Api\LensesRepositoryInterface;
use Bss\LensSystem\Model\ResourceModel\Lenses as LensesResource;
use Bss\LensSystem\Model\ResourceModel\Lenses\CollectionFactory as LensesCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * LensFittingHeightRepository Class
 * Action with model
 */
class LensesRepository implements LensesRepositoryInterface
{
    /**
     * @var LensesResource
     */
    protected $resource;

    /**
     * @var LensesSearchResultsInterface
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
     * @var LensesFactory
     */
    protected $lensesFactory;

    /**
     * @var LensesCollectionFactory
     */
    protected $lensesCollectionFactory;

    /**
     * @param LensesResource $resource
     * @param LensesFactory $lensesFactory
     * @param LensesSearchResultsInterfaceFactory $searchResultFactory
     * @param LensesCollectionFactory $lensesCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        LensesResource $resource,
        \Bss\LensSystem\Model\LensesFactory $lensesFactory,
        LensesSearchResultsInterfaceFactory $searchResultFactory,
        LensesCollectionFactory $lensesCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->lensesFactory = $lensesFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->lensesCollectionFactory = $lensesCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param LensesInterface $lenses
     * @return LensesInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(LensesInterface $lenses)
    {
        $this->resource->save($lenses);
        return $lenses;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $lenses = $this->lensesFactory->create();
        $this->resource->load($lenses, $id);
        if (!$lenses->getId()) {
            throw new NoSuchEntityException(__('Unable to find lenses with ID "%1"', $id));
        }
        return $lenses;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->lensesCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param LensesInterface $lenses
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(LensesInterface $lenses)
    {
        return $this->resource->delete($lenses);
    }
}
