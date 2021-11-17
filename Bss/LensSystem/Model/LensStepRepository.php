<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensStepInterface;
use Bss\LensSystem\Api\Data\LensStepSearchResultsInterface;
use Bss\LensSystem\Api\Data\LensStepSearchResultsInterfaceFactory;
use Bss\LensSystem\Api\LensStepRepositoryInterface;
use Bss\LensSystem\Model\ResourceModel\LensSteps as LensStepResource;
use Bss\LensSystem\Model\ResourceModel\LensSteps\CollectionFactory as LensStepCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * LensStepsRepository Class
 * Action with model
 */
class LensStepRepository implements LensStepRepositoryInterface
{
    /**
     * @var LensStepResource
     */
    protected $resource;

    /**
     * @var LensStepSearchResultsInterface
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
     * @var LensStepFactory
     */
    protected $lensStepFactory;

    /**
     * @var LensStepCollectionFactory
     */
    protected $lensStepCollectionFactory;

    /**
     * @param LensStepResource $resource
     * @param LensStepsFactory $lensStepFactory
     * @param LensStepSearchResultsInterfaceFactory $searchResultFactory
     * @param LensStepCollectionFactory $lensStepCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        LensStepResource $resource,
        \Bss\LensSystem\Model\LensStepsFactory $lensStepFactory,
        LensStepSearchResultsInterfaceFactory $searchResultFactory,
        LensStepCollectionFactory $lensStepCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->lensStepFactory = $lensStepFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->lensStepCollectionFactory = $lensStepCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param LensStepInterface $lensStep
     * @return LensStepInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(LensStepInterface $lensStep)
    {
        $this->resource->save($lensStep);
        return $lensStep;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $lensStep = $this->lensStepFactory->create();
        $this->resource->load($lensStep, $id);
        if (!$lensStep->getId()) {
            throw new NoSuchEntityException(__('Unable to find lensStep with ID "%1"', $id));
        }
        return $lensStep;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->lensStepCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param LensStepInterface $lensStep
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(LensStepInterface $lensStep)
    {
        return $this->resource->delete($lensStep);
    }
}
