<?php

namespace LoyaltyProgram\RewardPoint\Controller\Adminhtml\Goal;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    private $goalFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \LoyaltyProgram\RewardPoint\Model\GoalFactory $goalFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->goalFactory = $goalFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('goal_id');
        $rowData = $this->goalFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getTitle();
            if (!$rowData->getId()) {
                $this->messageManager->addError(__('Recipes Content not exist.'));
                $this->_redirect('rewardpoint/Goal/rowdata');
                return;
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Goal ').$rowTitle : __('Add Goal');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('LoyaltyProgram_RewardPoint::Add_row');
    }
}
