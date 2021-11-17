<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Options;

use Bss\LensSystem\Model\LensOptionsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Delete
 * Delete Options
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * @var LensOptionsFactory
     */
    protected $lensOptionsFactory;

    /**
     * @var \Bss\LensSystem\Model\LensOptionsRepository
     */
    protected $lensOptionsRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param LensOptionsFactory $lensOptionsFactory
     * @param \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
     */
    public function __construct(
        Context $context,
        LensOptionsFactory $lensOptionsFactory,
        \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
    ) {
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
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);
        try {
            $lensOptions = $this->lensOptionsRepository->getById($id);
            if ($lensOptions->getId()) {
                $this->lensOptionsRepository->delete($lensOptions);
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
