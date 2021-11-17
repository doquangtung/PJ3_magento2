<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Rules;

use Bss\LensSystem\Model\LensRuleFactory;
use Bss\LensSystem\Model\LensRuleRepository;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Save lens rule
 */
class Save extends \Magento\Backend\App\Action
{

    /**
     * @var LensRuleFactory
     */
    protected $lensRuleFactory;

    /**
     * @var LensRuleRepository
     */
    protected $lensRuleRepository;

    /**
     * @param Action\Context $context
     * @param LensRuleFactory $lensRuleFactory
     * @param LensRuleRepository $lensRuleRepository
     */
    public function __construct(
        Action\Context $context,
        LensRuleFactory $lensRuleFactory,
        LensRuleRepository $lensRuleRepository
    ) {
        $this->lensRuleFactory = $lensRuleFactory;
        $this->lensRuleRepository = $lensRuleRepository;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (isset($data['rule']['conditions'])) {
            $data['conditions'] = $data['rule']['conditions'];
        }
        if (isset($data['rule'])) {
            unset($data['rule']);
        }
        try {
            $lensRule = $this->lensRuleFactory->create();
            $ruleId = $this->getRequest()->getParam('rule_id');

            if ($ruleId) {
                $lensRule = $this->lensRuleRepository->getById($ruleId);
            }

            if (!$lensRule->getId() && $ruleId) {
                $this->messageManager->addErrorMessage(__('This rule is no longer exists.'));
                return $resultRedirect->setPath('lenssystem/rules/index');
            }

            $lensRule->loadPost($data);
            $this->lensRuleRepository->save($lensRule);

            $this->messageManager->addSuccessMessage(__('Discount rule has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                if ($this->getRequest()->getParam('back') == 'add') {
                    return $resultRedirect->setPath('lenssystem/rules/add');
                } else {
                    return $resultRedirect->setPath(
                        'lenssystem/rules/edit',
                        [
                            'rule_id' => $lensRule->getId(),
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            return $resultRedirect->setPath('lenssystem/rules/add');
        }
        return $resultRedirect->setPath('lenssystem/rules/index');
    }
}
