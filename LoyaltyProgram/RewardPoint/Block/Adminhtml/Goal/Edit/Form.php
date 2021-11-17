<?php
namespace LoyaltyProgram\RewardPoint\Block\Adminhtml\Goal\Edit;

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
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add New Row'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'goal_id',
            'text',
            [
                'name' => 'goal_id',
                'label' => __('Goal ID'),
                'id' => 'goal_id',
                'title' => __('Goal ID'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'goal_name',
            'text',
            [
                'name' => 'goal_name',
                'label' => __('Name'),
                'id' => 'goal_name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'goal_type',
            'select',
            [
                'name' => 'goal_type',
                'label' => __('Type'),
                'id' => 'goal_type',
                'title' => __('Type'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'goal_number',
            'text',
            [
                'name' => 'goal_number',
                'label' => __('Number'),
                'id' => 'goal_number',
                'title' => __('Number'),
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
