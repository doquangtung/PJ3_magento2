<?php
namespace LoyaltyProgram\RewardPoint\Block\Adminhtml\Activity\Edit;

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
            $fieldset->addField('earn_id', 'hidden', ['name' => 'earn_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add New Row'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'earn_name',
            'text',
            [
                'name' => 'earn_name',
                'label' => __('Name'),
                'id' => 'earn_name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_description',
            'text',
            [
                'name' => 'earn_description',
                'label' => __('Description'),
                'id' => 'earn_description',
                'title' => __('Description'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_point',
            'text',
            [
                'name' => 'earn_point',
                'label' => __('Point'),
                'id' => 'earn_point',
                'title' => __('Point'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_start',
            'text',
            [
                'name' => 'earn_start',
                'label' => __('Start'),
                'id' => 'earn_start',
                'title' => __('Start'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_end',
            'text',
            [
                'name' => 'earn_end',
                'label' => __('End'),
                'id' => 'earn_end',
                'title' => __('End'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_actived',
            'select',
            [
                'name' => 'earn_actived',
                'label' => __('Active'),
                'id' => 'earn_actived',
                'title' => __('Active'),
                'values' => $this->_options->getOptionTF(),
                'class' => 'status',
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
                'values' => $this->_options->getOptionGoalActivity(),
                'class' => 'status',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_priority',
            'text',
            [
                'name' => 'earn_priority',
                'label' => __('Protity'),
                'id' => 'earn_priority',
                'title' => __('Protity'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'earn_overlap',
            'select',
            [
                'name' => 'earn_overlap',
                'label' => __('Overlap'),
                'id' => 'earn_overlap',
                'title' => __('Overlap'),
                'values' => $this->_options-> getOptionTF(),
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
