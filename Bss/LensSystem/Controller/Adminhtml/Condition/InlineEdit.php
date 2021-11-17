<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Condition;

use Bss\LensSystem\Model\LensConditionRepository;
use Bss\LensSystem\Model\ResourceModel\LensCondition\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class InlineEdit
 * Inline edit Condition
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
    protected $lensConditionCollection;

    /**
     * @var LensConditionRepository
     */
    protected $lensConditionRepository;

    /**
     * @param  Context     $context
     * @param  Collection  $lensConditionCollection
     * @param  JsonFactory $jsonFactory
     * @param LensConditionRepository $lensConditionRepository
     */
    public function __construct(
        Context $context,
        Collection $lensConditionCollection,
        JsonFactory $jsonFactory,
        LensConditionRepository $lensConditionRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->lensConditionCollection = $lensConditionCollection;
        $this->lensConditionRepository = $lensConditionRepository;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
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
            $lensCondition = $this->lensConditionRepository->getById($post_items['id']);
            if ($lensCondition) {
                $lensCondition->addData($post_items);
                $this->lensConditionRepository->save($lensCondition);
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
