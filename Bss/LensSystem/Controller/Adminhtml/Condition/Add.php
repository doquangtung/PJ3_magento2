<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Condition;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Add
 * Add New Condition
 */
class Add extends Action implements HttpGetActionInterface
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add Lens Condition'));
        return $resultPage;
    }
}
