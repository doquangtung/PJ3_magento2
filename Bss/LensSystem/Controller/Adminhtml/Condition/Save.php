<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Condition;

use Bss\LensSystem\Model\LensConditionFactory;
use Bss\LensSystem\Model\LensConditionRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Save
 * Save selected entity_id Condition
 */
class Save extends Action implements HttpPostActionInterface
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
     * @return Redirect
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $storeId = (int) $this->getRequest()->getParam('store_id');
        $data = $this->getRequest()->getParams();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $lensConditionData = $this->lensConditionFactory->create();
            $lensConditionData->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            } else {
                $lensConditionData = $this->lensConditionRepository->getById($data['entity_id']);
                $params['entity_id'] = $data['entity_id'];
            }
            $lensConditionData->addData($data);
            $this->_eventManager->dispatch(
                'lenssystem_condition_prepare_save',
                ['object' => $this->lensConditionFactory, 'request' => $this->getRequest()]
            );
            try {
                $this->lensConditionRepository->save($lensConditionData);
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['entity_id'] = $lensConditionData->getId();
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
