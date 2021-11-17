<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface FittingHeightRepositoryInterface
{
    /**
     * @param Data\FittingHeightInterface $fittingHeight
     * @return mixed
     */
    public function save(Data\FittingHeightInterface $fittingHeight);

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
     * @param Data\FittingHeightInterface $fittingHeight
     * @return mixed
     */
    public function delete(Data\FittingHeightInterface $fittingHeight);
}
