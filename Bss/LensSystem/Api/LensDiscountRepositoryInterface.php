<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LensDiscountRepositoryInterface
{
    /**
     * @param Data\LensDiscountInterface $lenses
     * @return mixed
     */
    public function save(Data\LensDiscountInterface $lenses);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param Data\LensDiscountInterface $lenses
     * @return mixed
     */
    public function delete(Data\LensDiscountInterface $lenses);
}
