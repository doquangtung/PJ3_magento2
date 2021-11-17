<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LensOptionsSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return LensOptionsSearchResultsInterface
     */
    public function setItems(array $items);
}
