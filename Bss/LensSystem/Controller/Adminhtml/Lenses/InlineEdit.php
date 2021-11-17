<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Lenses;

use Bss\LensSystem\Model\ResourceModel\Lenses\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class InlineEdit
 * Edit selected entity_id
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
    protected $lensesCollection;

    /**
     * @var \Bss\LensSystem\Model\LensesRepository
     */
    protected $lensesRepository;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param Collection $lensesCollection
     * @param JsonFactory $jsonFactory
     * @param \Bss\LensSystem\Model\LensesRepository $lensesRepository
     */
    public function __construct(
        Context $context,
        Collection $lensesCollection,
        JsonFactory $jsonFactory,
        \Bss\LensSystem\Model\LensesRepository $lensesRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->lensesCollection = $lensesCollection;
        $this->lensesRepository = $lensesRepository;
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
            $lenses = $this->lensesRepository->getById($post_items['id']);
            if ($lenses) {
                $lenses->addData($post_items);
                $this->lensesRepository->save($lenses);
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