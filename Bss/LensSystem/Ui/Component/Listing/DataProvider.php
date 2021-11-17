<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Listing;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as UiDataProvider;

/**
 * Class DataProvider
 * DataProvider for Listing
 */
class DataProvider extends UiDataProvider
{
    /**
     * @param SearchResultInterface $searchResult
     * @return array
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        /** Add here needed EAV attributes to display on grid **/
        $searchResult->setStoreId($this->request->getParam('store', 0))->addAttributeToSelect('*');
        return parent::searchResultToOutput($searchResult);
    }

    /**
     * @return void
     */
    protected function prepareUpdateUrl()
    {
        $storeId = $this->request->getParam('store', 0);
        if ($storeId) {
            $this->data['config']['update_url'] = sprintf(
                '%s%s/%s',
                $this->data['config']['update_url'],
                'store',
                $storeId
            );
        }
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->searchResultToOutput($this->reporting->search($this->getSearchCriteria()));
    }
}
