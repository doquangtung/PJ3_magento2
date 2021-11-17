<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Rules;

use Bss\LensSystem\Model\LensRuleRepository;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Delete lens rule
 */
class Delete extends Action
{
    /**
     * @var LensRuleRepository
     */
    protected $lensRuleRepository;

    /**
     * @param Action\Context $context
     * @param LensRuleRepository $lensRuleRepository
     */
    public function __construct(
        Action\Context $context,
        LensRuleRepository $lensRuleRepository
    ) {
        $this->lensRuleRepository = $lensRuleRepository;

        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('rule_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $lensRule = $this->lensRuleRepository->getById($id);

                if ($lensRule) {
                    $this->lensRuleRepository->delete($lensRule);
                }

                $this->messageManager->addSuccessMessage(__('The discount rule is deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['rule_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('The discount rule does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
