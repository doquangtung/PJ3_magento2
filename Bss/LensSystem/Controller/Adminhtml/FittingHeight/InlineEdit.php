<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\FittingHeight;

use Bss\LensSystem\Model\ResourceModel\LensFittingHeight\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class InlineEdit
 * Fitting Height Inline Edit
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
    protected $lensFittingHeightCollection;

    /**
     * @var \Bss\LensSystem\Model\LensFittingHeightRepository
     */
    protected $lensFittingHeightRepository;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param Collection $lensFittingHeightCollection
     * @param JsonFactory $jsonFactory
     * @param \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
     */
    public function __construct(
        Context $context,
        Collection $lensFittingHeightCollection,
        JsonFactory $jsonFactory,
        \Bss\LensSystem\Model\LensFittingHeightRepository $lensFittingHeightRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->lensFittingHeightCollection = $lensFittingHeightCollection;
        $this->lensFittingHeightRepository = $lensFittingHeightRepository;
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
            $lensFittingHeight = $this->lensFittingHeightRepository->getById($post_items['id']);
            if ($lensFittingHeight) {
                $lensFittingHeight->addData($post_items);
                $this->lensFittingHeightRepository->save($lensFittingHeight);
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
