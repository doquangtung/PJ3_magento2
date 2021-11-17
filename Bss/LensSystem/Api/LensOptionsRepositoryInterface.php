<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LensOptionsRepositoryInterface
{
    /**
     * @param Data\LensOptionsInterface $options
     * @return mixed
     */
    public function save(Data\LensOptionsInterface $options);

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
     * @param Data\LensOptionsInterface $options
     * @return mixed
     */
    public function delete(Data\LensOptionsInterface $options);
}
