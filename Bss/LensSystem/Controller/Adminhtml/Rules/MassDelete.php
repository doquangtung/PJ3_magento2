<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Rules;

use Bss\LensSystem\Model\ResourceModel\LensRule\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * Lens Rule Mass Delete
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
    protected $lensRuleCollection;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param Collection $lensRuleCollection
     */
    public function __construct(
        Context $context,
        Filter $filter,
        Collection $lensRuleCollection
    ) {
        $this->filter = $filter;
        $this->lensRuleCollection = $lensRuleCollection;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException | \Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->lensRuleCollection);
        $collectionSize = $collection->getSize();
        $collection->walk('delete');
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
