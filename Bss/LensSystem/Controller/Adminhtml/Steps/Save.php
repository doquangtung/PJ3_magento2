<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Steps;

use Bss\LensSystem\Model\LensStepsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Save
 * Save selected entity_id steps
 */
class Save extends Action implements HttpPostActionInterface
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
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $storeId = (int) $this->getRequest()->getParam('store_id');
        $data = $this->getRequest()->getParams();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $lensStepsData = $this->lensStepsFactory->create();
            $lensStepsData->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            } else {
                $lensStepsData = $this->lensStepRepository->getById($data['entity_id']);
                $params['entity_id'] = $data['entity_id'];
            }
            $lensStepsData->addData($data);
            $this->_eventManager->dispatch(
                'lenssystem_options_prepare_save',
                ['object' => $this->lensStepsFactory, 'request' => $this->getRequest()]
            );
            try {
                $this->lensStepRepository->save($lensStepsData);
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['entity_id'] = $lensStepsData->getId();
                    $params['_current'] = true;
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
            }
            $this->_getSession()->setFormData($this->getRequest()->getPostValue());
            return $resultRedirect->setPath('*/*/edit', $params);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
