<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\FittingHeight;

use Bss\LensSystem\Model\LensFittingHeightFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Delete
 * Delete Fitting Height
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * @var LensFittingHeightFactory
     */
    protected $lensFittingHeightFactory;

    /**
     * @var \Bss\LensSystem\Model\LensFittingHeightRepository
     */
    protected $fittingHeightRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param LensFittingHeightFactory $lensFittingHeightFactory
     */
    public function __construct(
        Context $context,
        LensFittingHeightFactory $lensFittingHeightFactory,
        \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
    ) {
        $this->lensFittingHeightFactory = $lensFittingHeightFactory;
        $this->fittingHeightRepository = $lensFittingHeightRepository;
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
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $lensOptionsFactory = $this->fittingHeightRepository->getById($id);
            if ($lensOptionsFactory) {
                $this->fittingHeightRepository->delete($lensOptionsFactory);
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
