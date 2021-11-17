<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Api\Data\LensDiscountSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Lens Discount Rule Search Result
 * Implements
 */
class LensRuleSearchResults extends SearchResults implements LensDiscountSearchResultsInterface
{
}
