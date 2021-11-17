<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Condition;

use Bss\LensSystem\Model\LensConditionFactory;
use Bss\LensSystem\Model\LensConditionRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Delete
 * Delete Condition
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * @var LensConditionFactory
     */
    protected $lensConditionFactory;

    /**
     * @var LensConditionRepository
     */
    protected $lensConditionRepository;

    /**
     * @param Context $context
     * @param LensConditionFactory $lensConditionFactory
     * @param LensConditionRepository $lensConditionRepository
     */
    public function __construct(
        Context $context,
        LensConditionFactory $lensConditionFactory,
        LensConditionRepository $lensConditionRepository
    ) {
        $this->lensConditionFactory = $lensConditionFactory;
        $this->lensConditionRepository = $lensConditionRepository;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bss_LensSystem::condition');
    }

    /**
     * Delete action
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);
        try {
            $lensCondition = $this->lensConditionRepository->getById($id);
            if ($lensCondition->getId()) {
                $this->lensConditionRepository->delete($lensCondition);
                $this->messageManager->addSuccessMessage(__('You deleted the record.'));
            } else {
                $this->messageManager->addErrorMessage(__('Record does not exist.'));
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        return $resultRedirect->setPath('*/*');
    }
}
