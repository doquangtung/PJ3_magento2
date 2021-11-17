<?php
declare(strict_types=1);

namespace Bss\LensSystem\Controller\Adminhtml\Rules;

/**
 * Get rule detail in condition
 */
class NewActionHtml extends \Bss\LensSystem\Controller\Adminhtml\Rules\Rule
{
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type = $typeArr[0];

        $model = $this->_objectManager->create(
            $type
        )->setId(
            $id
        )->setType(
            $type
        )->setRule(
            $this->ruleFactory->create()
        )->setPrefix(
            'actions'
        );
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof \Magento\Rule\Model\Condition\AbstractCondition) {
            $model->setJsFormObject('lens_rules_form');
            $model->setFormName('lens_rules_form');
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }
}
