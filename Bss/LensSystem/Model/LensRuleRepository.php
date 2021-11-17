<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensDiscountInterface;
use Bss\LensSystem\Api\Data\LensDiscountSearchResultsInterfaceFactory;
use Bss\LensSystem\Api\LensDiscountRepositoryInterface;
use Bss\LensSystem\Model\ResourceModel\LensRule as RuleResource;
use Bss\LensSystem\Model\ResourceModel\LensRule\CollectionFactory as RuleCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * RuleRepository Class
 * Action with model
 */
class LensRuleRepository implements LensDiscountRepositoryInterface
{
    /**
     * @var RuleResource
     */
    protected $resource;

    /**
     * @var LensDiscountSearchResultsInterfaceFactory
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
     * @var LensRuleFactory
     */
    protected $ruleFactory;

    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @param RuleResource $resource
     * @param LensRuleFactory $ruleFactory
     * @param LensDiscountSearchResultsInterfaceFactory $searchResultFactory
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        RuleResource $resource,
        \Bss\LensSystem\Model\LensRuleFactory $ruleFactory,
        LensDiscountSearchResultsInterfaceFactory $searchResultFactory,
        RuleCollectionFactory $ruleCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->ruleFactory = $ruleFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param LensDiscountInterface $rule
     * @return LensDiscountInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(LensDiscountInterface $rule)
    {
        $this->resource->save($rule);
        return $rule;
    }

    /**
     * @param $id
     * @return LensRule
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $rule = $this->ruleFactory->create();
        $this->resource->load($rule, $id);
        if (!$rule->getId()) {
            throw new NoSuchEntityException(__('Unable to find discount rule with ID "%1"', $id));
        }
        return $rule;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->ruleCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param LensDiscountInterface $rule
     * @return RuleResource
     * @throws Exception
     */
    public function delete(LensDiscountInterface $rule)
    {
        return $this->resource->delete($rule);
    }
}
