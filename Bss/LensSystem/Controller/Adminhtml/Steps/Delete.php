<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Steps;

use Bss\LensSystem\Model\LensStepsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Delete
 * Delete Steps
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * @var LensStepsFactory
     */
    protected $lensStepsFactory;

    /**
     * @var \Bss\LensSystem\Model\LensStepRepository
     */
    protected $lensStepRepository;

    /**
     * @param  Context           $context
     * @param  LensStepsFactory $lensStepsFactory
     * @param \Bss\LensSystem\Model\LensStepRepository $lensStepRepository
     */
    public function __construct(
        Context $context,
        LensStepsFactory $lensStepsFactory,
        \Bss\LensSystem\Model\LensStepRepository $lensStepRepository
    ) {
        $this->lensStepsFactory = $lensStepsFactory;
        $this->lensStepRepository = $lensStepRepository;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bss_LensSystem::steps');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);
        try {
            $lensSteps = $this->lensStepRepository->getById($id);
            if ($lensSteps->getId()) {
                $this->lensStepRepository->delete($lensSteps);
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
