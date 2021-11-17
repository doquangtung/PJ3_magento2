<?php

namespace LoyaltyProgram\RewardPoint\Controller\Adminhtml\Activity;

class Save extends \Magento\Backend\App\Action
{
    var $activityFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \LoyaltyProgram\RewardPoint\Model\ActivityFactory $activityFactory
    ) {
        parent::__construct($context);
        $this->activityFactory = $activityFactory;
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
            $this->_redirect('rewardpoint/Activity/Addrow');
            return;
        }
        try {
            $rowData = $this->activityFactory->create();
            $rowData->setData($data);
            if (isset($data['earn_id'])) {
                $rowData->setId($data['earn_id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Activity data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('rewardpoint/Activity/Index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('LoyaltyProgram_RewardPoint::save');
    }
}
