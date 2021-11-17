<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\FittingHeight;

use Bss\LensSystem\Model\LensFittingHeightFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Save
 * Fitting Height Save
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var LensFittingHeightFactory
     */
    protected $lensFittingHeightFactory;

    /**
     * @var \Bss\LensSystem\Model\LensFittingHeightRepository
     */
    protected $lensFittingHeightRepository;

    /**
     * @param Context $context
     * @param LensFittingHeightFactory $lensFittingHeightFactory
     * @param \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
     */
    public function __construct(
        Context $context,
        LensFittingHeightFactory $lensFittingHeightFactory,
        \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
    ) {
        $this->lensFittingHeightFactory = $lensFittingHeightFactory;
        $this->lensFittingHeightRepository = $lensFittingHeightRepository;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bss_LensSystem::fittingheight');
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
            $lensOptionData = $this->lensFittingHeightFactory->create();
            $lensOptionData->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['id'])) {
                $data['id'] = null;
            } else {
                $lensOptionData = $this->lensFittingHeightRepository->getById($data['id']);
                $params['id'] = $data['id'];
            }
            $lensOptionData->addData($data);
            $this->_eventManager->dispatch(
                'lenssystem_fittingheight_prepare_save',
                ['object' => $this->lensFittingHeightFactory, 'request' => $this->getRequest()]
            );
            try {
                $this->lensFittingHeightRepository->save($lensOptionData);
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['id'] = $lensOptionData->getId();
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
