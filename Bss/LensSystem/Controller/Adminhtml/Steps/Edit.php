<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Steps;

use Bss\LensSystem\Model\LensStepsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * Edit New Steps
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

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
     * @param  PageFactory       $resultPageFactory
     * @param  LensStepsFactory $lensStepsFactory
     * @param \Bss\LensSystem\Model\LensStepRepository $lensStepRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LensStepsFactory $lensStepsFactory,
        \Bss\LensSystem\Model\LensStepRepository $lensStepRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
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
     * Edit
     *
     * @return \Magento\Backend\Model\View\Result\Page | \Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $lensStepsData = $this->lensStepsFactory->create();
        if ($id) {
            $lensStepsData = $this->lensStepRepository->getById($id);
            if (!$lensStepsData->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $lensStepsData->addData($data);
        }
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bss_LensSystem::steps');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Lens Steps'));
        return $resultPage;
    }
}
