<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Lenses;

use Bss\LensSystem\Model\LensesFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Delete
 * Delete by ID
 */
class Delete extends Action implements HttpGetActionInterface
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
     * Delete constructor.
     * @param Context $context
     * @param LensesFactory $lensesFactory
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
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id', null);
        try {
            $lenses = $this->lensesRepository->getById($id);
            if ($lenses->getId()) {
                $this->lensesRepository->delete($lenses);
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
