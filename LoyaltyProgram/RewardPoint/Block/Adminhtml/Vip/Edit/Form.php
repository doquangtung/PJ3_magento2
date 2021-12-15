<?php
namespace LoyaltyProgram\RewardPoint\Block\Adminhtml\Vip\Edit;

/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \LoyaltyProgram\RewardPoint\Model\Status $options,
        array $data = []
    ) {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('vip_id', 'hidden', ['name' => 'vip_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add New Row'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'vip_name',
            'text',
            [
                'name' => 'vip_name',
                'label' => __('Name'),
                'id' => 'vip_name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'vip_description',
            'text',
            [
                'name' => 'vip_description',
                'label' => __('Description'),
                'id' => 'vip_description',
                'title' => __('Description'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'goal_id',
            'select',
            [
                'name' => 'goal_id',
                'label' => __('Goal'),
                'id' => 'goal_id',
                'title' => __('Goal'),
                'values' => $this->_options->getOptionGoalVip(),
                'class' => 'status',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'vip_rate',
            'text',
            [
                'name' => 'vip_rate',
                'label' => __('Rate'),
                'id' => 'vip_rate',
                'title' => __('Rate'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
