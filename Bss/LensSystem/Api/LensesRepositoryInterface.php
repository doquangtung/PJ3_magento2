<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LensesRepositoryInterface
{
    /**
     * @param Data\LensesInterface $lenses
     * @return mixed
     */
    public function save(Data\LensesInterface $lenses);

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
     * @param Data\LensesInterface $lenses
     * @return mixed
     */
    public function delete(Data\LensesInterface $lenses);
}
