<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\FittingHeight;

use Bss\LensSystem\Model\LensFittingHeightFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * Edit Fitting Height
 */
class Edit extends Action implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

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
     * @param PageFactory $resultPageFactory
     * @param LensFittingHeightFactory $lensFittingHeightFactory
     * @param \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LensFittingHeightFactory $lensFittingHeightFactory,
        \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
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
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $lensOptionData = $this->lensFittingHeightFactory->create();
        if ($id) {
            $lensOptionData = $this->lensFittingHeightRepository->getById($id);
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
        $resultPage->setActiveMenu('Bss_LensSystem::fittingheight');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Fitting Height'));
        return $resultPage;
    }
}
