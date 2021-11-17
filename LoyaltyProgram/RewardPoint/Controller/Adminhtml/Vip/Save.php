<?php

namespace LoyaltyProgram\RewardPoint\Controller\Adminhtml\Vip;

class Save extends \Magento\Backend\App\Action
{
    var $vipFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \LoyaltyProgram\RewardPoint\Model\VipFactory $vipFactory
    ) {
        parent::__construct($context);
        $this->vipFactory = $vipFactory;
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
            $this->_redirect('rewardpoint/Vip/Addrow');
            return;
        }
        try {
            $rowData = $this->vipFactory->create();
            $rowData->setData($data);
            if (isset($data['vip_id'])) {
                $rowData->setId($data['vip_id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Vip data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('rewardpoint/Vip/Index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('LoyaltyProgram_RewardPoint::save');
    }
}
