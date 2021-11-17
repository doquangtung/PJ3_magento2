<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface LensConditionSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return LensConditionSearchResultsInterface
     */
    public function setItems(array $items);
}
