<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Steps;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Add
 * Add New Steps
 */
class Add extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add Lens Steps'));
        return $resultPage;
    }
}
