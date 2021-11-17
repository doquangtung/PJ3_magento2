<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LensStepSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return FittingHeightSearchResultsInterface
     */
    public function setItems(array $items);
}
