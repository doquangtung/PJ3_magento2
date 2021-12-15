<?php
declare(strict_types=1);

namespace LoyaltyProgram\RewardPoint\Model\ResourceModel\Goal\Grid;

use LoyaltyProgram\RewardPoint\Model\ResourceModel\Goal;
use Exception;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;

/** Class Collection prepare data for Goal grid page  */
class Collection extends Goal\Collection implements SearchResultInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'goal_grid_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'grid_collection';

    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * @var SearchCriteriaInterface
     */
    protected $searchCriteria;

    /**
     * Constrcut Goal collection
     */
    public function _construct()
    {
        $this->_init(Document::class, Goal::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface
     */
    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this
     * @throws Exception
     */
    public function setItems(array $items = null)
    {
        if ($items) {
            foreach ($items as $item) {
                $this->addItem($item);
            }
        }
        return $this;
    }
}
