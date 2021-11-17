<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Condition;

use Bss\LensSystem\Model\LensConditionFactory;
use Bss\LensSystem\Model\LensConditionRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * Edit New Condition
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var LensConditionFactory
     */
    protected $lensConditionFactory;

    /**
     * @var LensConditionRepository
     */
    protected $lensConditionRepository;

    /**
     * @param  Context           $context
     * @param  PageFactory       $resultPageFactory
     * @param  LensConditionFactory $lensConditionFactory
     * @param LensConditionRepository $lensConditionRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LensConditionFactory $lensConditionFactory,
        LensConditionRepository $lensConditionRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
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
     * @return Redirect|Page
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $lensConditionData = $this->lensConditionFactory->create();
        if ($id) {
            $lensConditionData = $this->lensConditionRepository->getById($id);
            if (!$lensConditionData->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $lensConditionData->addData($data);
        }
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bss_LensSystem::condition');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Condition'));
        return $resultPage;
    }
}
