<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LensStepRepositoryInterface
{
    /**
     * @param Data\LensStepInterface $lenses
     * @return mixed
     */
    public function save(Data\LensStepInterface $lenses);

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
     * @param Data\LensStepInterface $lenses
     * @return mixed
     */
    public function delete(Data\LensStepInterface $lenses);
}
