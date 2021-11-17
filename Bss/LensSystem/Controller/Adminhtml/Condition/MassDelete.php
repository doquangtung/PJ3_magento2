<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Condition;

use Bss\LensSystem\Model\ResourceModel\LensCondition\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * Mass delete Condition
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var Collection
     */
    protected $lensConditionData;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param Collection $lensConditionData
     */
    public function __construct(
        Context $context,
        Filter $filter,
        Collection $lensConditionData
    ) {
        $this->filter = $filter;
        $this->lensConditionData = $lensConditionData;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->lensConditionData);
        $collectionSize = $collection->getSize();
        $collection->walk('delete');
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
