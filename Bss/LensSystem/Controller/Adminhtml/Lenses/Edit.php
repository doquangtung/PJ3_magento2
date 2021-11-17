<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Lenses;

use Bss\LensSystem\Model\LensesFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * Edit values selected entity_id
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var LensesFactory
     */
    protected $lensesFactory;

    /**
     * @var \Bss\LensSystem\Model\LensesRepository
     */
    protected $lensesRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LensesFactory $lensesFactory
     * @param \Bss\LensSystem\Model\LensesRepository $lensesRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LensesFactory $lensesFactory,
        \Bss\LensSystem\Model\LensesRepository $lensesRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
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
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $lensesData = $this->lensesFactory->create();
        if ($id) {
            $lensesData = $this->lensesRepository->getById($id);
            if (!$lensesData->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $lensesData->addData($data);
        }
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bss_LensSystem::lenses');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Lenses'));
        return $resultPage;
    }
}
