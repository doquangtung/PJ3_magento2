<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Lenses;

use Bss\LensSystem\Model\LensesFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Save
 * Save values to selected entity_id
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var LensesFactory
     */
    protected $lensesFactory;

    /**
     * @var \Bss\LensSystem\Model\LensesRepository
     */
    protected $lensesRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param LensesFactory $lensesFactory
     * @param \Bss\LensSystem\Model\LensesRepository $lensesRepository
     */
    public function __construct(
        Context $context,
        LensesFactory $lensesFactory,
        \Bss\LensSystem\Model\LensesRepository $lensesRepository
    ) {
        $this->lensesFactory = $lensesFactory;
        $this->lensesRepository = $lensesRepository;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bss_LensSystem::lenses');
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
            $lensesData = $this->lensesFactory->create();
            $lensesData->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['id'])) {
                $data['id'] = null;
            } else {
                $lensesData = $this->lensesRepository->getById($data['id']);
                $params['id'] = $data['id'];
            }
            $lensesData->addData($data);
            $this->_eventManager->dispatch(
                'lenssystem_lenses_prepare_save',
                ['object' => $this->lensesFactory, 'request' => $this->getRequest()]
            );
            try {
                $this->lensesRepository->save($lensesData);
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['id'] = $lensesData->getId();
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
