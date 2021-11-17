<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Options;

use Bss\LensSystem\Model\ResourceModel\LensOptions\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * Mass Delete selected entity_id options
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
    protected $lensOptionData;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param Collection $lensOptionData
     */
    public function __construct(
        Context $context,
        Filter $filter,
        Collection $lensOptionData
    ) {
        $this->filter = $filter;
        $this->lensOptionData = $lensOptionData;
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
        $collection = $this->filter->getCollection($this->lensOptionData);
        $collectionSize = $collection->getSize();
        $collection->walk('delete');
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
