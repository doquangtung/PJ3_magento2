<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensConditionInterface;
use Bss\LensSystem\Api\Data\LensConditionSearchResultsInterface;
use Bss\LensSystem\Api\Data\LensConditionSearchResultsInterfaceFactory;
use Bss\LensSystem\Api\LensConditionRepositoryInterface;
use Bss\LensSystem\Model\ResourceModel\LensCondition as LensConditionResource;
use Bss\LensSystem\Model\ResourceModel\LensCondition\CollectionFactory as LensConditionCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * LensConditionRepository Class
 * Action with model
 */
class LensConditionRepository implements LensConditionRepositoryInterface
{
    /**
     * @var LensConditionResource
     */
    protected $resource;

    /**
     * @var LensConditionSearchResultsInterface
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
     * @var LensConditionFactory
     */
    protected $lensConditionFactory;

    /**
     * @var LensConditionCollectionFactory
     */
    protected $lensConditionCollectionFactory;

    /**
     * @param LensConditionResource $resource
     * @param LensConditionFactory $lensConditionFactory
     * @param LensConditionSearchResultsInterfaceFactory $searchResultFactory
     * @param LensConditionCollectionFactory $lensConditionCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        LensConditionResource $resource,
        \Bss\LensSystem\Model\LensConditionFactory $lensConditionFactory,
        LensConditionSearchResultsInterfaceFactory $searchResultFactory,
        LensConditionCollectionFactory $lensConditionCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->lensConditionFactory = $lensConditionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->lensConditionCollectionFactory = $lensConditionCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param LensConditionInterface $lensCondition
     * @return LensConditionInterface
     * @throws AlreadyExistsException
     */
    public function save(LensConditionInterface $lensCondition)
    {
        $this->resource->save($lensCondition);
        return $lensCondition;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $lensCondition = $this->lensConditionFactory->create();
        $this->resource->load($lensCondition, $id);
        if (!$lensCondition->getId()) {
            throw new NoSuchEntityException(__('Unable to find lensCondition with ID "%1"', $id));
        }
        return $lensCondition;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->lensConditionCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param LensConditionInterface $lensCondition
     * @return LensConditionResource
     * @throws Exception
     */
    public function delete(LensConditionInterface $lensCondition)
    {
        return $this->resource->delete($lensCondition);
    }
}
