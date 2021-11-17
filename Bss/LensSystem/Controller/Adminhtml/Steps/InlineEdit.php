<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Steps;

use Bss\LensSystem\Model\ResourceModel\LensSteps\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class InlineEdit
 * InlineEdit Steps
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
    protected $lensStepsCollection;

    /**
     * @var \Bss\LensSystem\Model\LensStepRepository
     */
    protected $lensStepRepository;

    /**
     * @param  Context     $context
     * @param  Collection  $lensStepsCollection
     * @param  JsonFactory $jsonFactory
     * @param \Bss\LensSystem\Model\LensStepRepository $lensStepRepository
     */
    public function __construct(
        Context $context,
        Collection $lensStepsCollection,
        JsonFactory $jsonFactory,
        \Bss\LensSystem\Model\LensStepRepository $lensStepRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->lensStepsCollection = $lensStepsCollection;
        $this->lensStepRepository = $lensStepRepository;
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
            $lensStep = $this->lensStepRepository->getById($post_items['id']);
            if ($lensStep) {
                $lensStep->addData($post_items);
                $this->lensStepRepository->save($lensStep);
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
