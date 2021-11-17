<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Options;

use Bss\LensSystem\Model\LensOptionsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Save
 * Save Options
 */
class Save extends Action implements HttpPostActionInterface
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
     * @var \Bss\LensSystem\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * @param Context $context
     * @param LensOptionsFactory $lensOptionsFactory
     * @param \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
     * @param \Bss\LensSystem\Model\ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        LensOptionsFactory $lensOptionsFactory,
        \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository,
        \Bss\LensSystem\Model\ImageUploader $imageUploader
    ) {
        $this->lensOptionsFactory = $lensOptionsFactory;
        $this->lensOptionsRepository = $lensOptionsRepository;
        $this->imageUploader = $imageUploader;
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
            if (isset($data['tooltip_image'])) {
                $data['tooltip_image'] = $data['tooltip_image'][0]['name'];
            }
            if (isset($data['image'])) {
                $data['image'] = $data['image'][0]['name'];
            }
            if (isset($data['image_revert'])) {
                $data['image_revert'] = $data['image_revert'][0]['name'];
            }
            $lensOptionData = $this->lensOptionsFactory->create();
            $lensOptionData->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            } else {
                $lensOptionData = $this->lensOptionsRepository->getById($data['entity_id']);
                $params['entity_id'] = $data['entity_id'];
            }
            $lensOptionData->addData($data);
            $this->_eventManager->dispatch(
                'lenssystem_options_prepare_save',
                ['object' => $this->lensOptionsFactory, 'request' => $this->getRequest()]
            );
            try {
                $this->lensOptionsRepository->save($lensOptionData);
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['entity_id'] = $lensOptionData->getId();
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
