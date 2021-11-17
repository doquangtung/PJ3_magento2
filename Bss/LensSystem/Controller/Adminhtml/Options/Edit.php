<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Options;

use Bss\LensSystem\Model\LensOptionsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * Edit Options
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var LensOptionsFactory
     */
    protected $lensOptionsFactory;

    /**
     * @var \Bss\LensSystem\Model\LensOptionsRepository
     */
    protected $lensOptionsRepository;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LensOptionsFactory $lensOptionsFactory
     * @param \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LensOptionsFactory $lensOptionsFactory,
        \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->lensOptionsFactory = $lensOptionsFactory;
        $this->lensOptionsRepository = $lensOptionsRepository;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bss_LensSystem::options');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $lensOptionData = $this->lensOptionsFactory->create();
        if ($id) {
            $lensOptionData = $this->lensOptionsRepository->getById($id);
            if (!$lensOptionData->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $lensOptionData->addData($data);
        }
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bss_LensSystem::options');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Lens Options'));
        return $resultPage;
    }
}
