<?php

namespace LoyaltyProgram\RewardPoint\Controller\Adminhtml\Goal;

class Save extends \Magento\Backend\App\Action
{
    var $goalFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \LoyaltyProgram\RewardPoint\Model\GoalFactory $goalFactory
    ) {
        parent::__construct($context);
        $this->goalFactory = $goalFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // $rowId = (int) $this->getRequest()->getParam('id');
        // echo '<pre>'; print_r($rowId); die();
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('rewardpoint/Goal/Addrow');
            return;
        }
        try {
            $rowData = $this->goalFactory->create();
            $rowData->setData($data);
            if (isset($data['goal_id'])) {
                $rowData->setId($data['goal_id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Goal data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('rewardpoint/Goal/Index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('LoyaltyProgram_RewardPoint::save');
    }
}
