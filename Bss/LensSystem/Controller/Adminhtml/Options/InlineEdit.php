<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Options;

use Bss\LensSystem\Model\ResourceModel\LensOptions\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class InlineEdit
 * InlineEdit Options
 */
class InlineEdit extends Action implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Collection
     */
    protected $lensOptionsCollection;

    /**
     * @var \Bss\LensSystem\Model\LensOptionsRepository
     */
    protected $lensOptionsRepository;

    /**
     * @param Context $context
     * @param Collection $lensOptionsCollection
     * @param JsonFactory $jsonFactory
     * @param \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
     */
    public function __construct(
        Context $context,
        Collection $lensOptionsCollection,
        JsonFactory $jsonFactory,
        \Bss\LensSystem\Model\LensOptionsRepository $lensOptionsRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->lensOptionsCollection = $lensOptionsCollection;
        $this->lensOptionsRepository = $lensOptionsRepository;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $post_items = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($post_items))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        try {
            $options = $this->lensOptionsRepository->getById($post_items['id']);
            if ($options) {
                $options->addData($post_items);
                $this->lensOptionsRepository->save($options);
            }
        } catch (\Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
