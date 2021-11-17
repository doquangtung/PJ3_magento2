<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Rules;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Add lens rule
 */
class Add extends \Magento\Backend\App\Action
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add New Rule'));

        return $resultPage;
    }

}
