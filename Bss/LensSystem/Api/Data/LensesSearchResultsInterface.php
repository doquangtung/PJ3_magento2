<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LensesSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return LensesSearchResultsInterface
     */
    public function setItems(array $items);
}
