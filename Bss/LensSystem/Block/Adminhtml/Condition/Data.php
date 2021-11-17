<?php
declare(strict_types=1);

namespace Bss\LensSystem\Block\Adminhtml\Condition;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Data
 * Get data for jsTree
 */
class Data extends \Magento\Backend\Block\Template
{
    /**
     * @var \Bss\LensSystem\Model\ResourceModel\LensSteps\CollectionFactory
     */
    protected $lensStepFactory;

    /**
     * @var \Bss\LensSystem\Model\ResourceModel\LensOptions\CollectionFactory
     */
    protected $lensOptionFactory;

    /**
     * @var \Bss\LensSystem\Model\ResourceModel\LensCondition\CollectionFactory
     */
    protected $lensConditionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Bss\LensSystem\Model\ResourceModel\LensSteps\CollectionFactory $lensStepFactory
     * @param \Bss\LensSystem\Model\ResourceModel\LensOptions\CollectionFactory $lensOptionFactory
     * @param \Bss\LensSystem\Model\ResourceModel\LensCondition\CollectionFactory $lensConditionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Bss\LensSystem\Model\ResourceModel\LensSteps\CollectionFactory $lensStepFactory,
        \Bss\LensSystem\Model\ResourceModel\LensOptions\CollectionFactory $lensOptionFactory,
        \Bss\LensSystem\Model\ResourceModel\LensCondition\CollectionFactory $lensConditionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->lensStepFactory = $lensStepFactory;
        $this->lensOptionFactory = $lensOptionFactory;
        $this->lensConditionFactory = $lensConditionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Get store identifier
     * @return  int
     * @throws NoSuchEntityException
     */
    public function getStoreId()
    {
        return (int) $this->getRequest()->getParam('store');
    }

    /**
     * Get lens steps data for jsTree
     * @return array[]
     * @throws LocalizedException
     */
    public function getLensSteps()
    {
        $stepCollection = $this->lensStepFactory->create()->addAttributeToSelect('*')->setStoreId($this->getStoreId());
        $res = [
            [
                'id' => 'root',
                'parent' => '#',
                'text' => 'Lens Steps',
                "state" => ["opened" => true]
            ]
        ];
        foreach ($stepCollection as $item) {
            $stepId = $item->getData('entity_id');
            $data = [
                'id' => $stepId,
                'parent' => 'root',
                'text' => $item->getData('step_title'),
                'li_attr' => [
                    'type' => 'step',
                    'entity_id' => $stepId,
                ]
            ];
            array_push($res, $data);
        }
        return $res;
    }

    /**
     * Get lens options data for jsTree
     * @return array[]
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getLensOptions()
    {
        $optionCollection = $this->lensOptionFactory->create()
            ->addAttributeToSelect('*')
            ->setStoreId($this->getStoreId());
        $res = [
            [
                'id' => 'root',
                'parent' => '#',
                'text' => 'Lens Options',
                "state" => ["opened" => true]
            ]
        ];
        foreach ($optionCollection as $item) {
            $optionId = $item->getData('entity_id');
            $data = [
                'id' => $optionId,
                'parent' => 'root',
                'text' => $item->getData('title'),
                'li_attr' => [
                    'type' => 'option',
                    'entity_id' => $optionId,
                    'price' => 0,
                    'included' => 0
                ]
            ];
            array_push($res, $data);
        }
        return $res;
    }

    /**
     * Get condition id
     * @return int
     */
    public function getConditionId()
    {
        return (int) $this->getRequest()->getParam('entity_id', 0);
    }

    /**
     * Get Lens Step Name by Id
     * @param $stepId
     * @return array|mixed|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getLensStepName($stepId)
    {
        $step = $this->lensStepFactory->create()->addAttributeToSelect('*')
                                                ->setStoreId($this->getStoreId())
                                                ->addAttributeToFilter('entity_id', $stepId)->getFirstItem();
        if ($step->getData('step_title') == '') {
            return 'null_data';
        }
        return $step->getData('step_title');
    }

    /**
     * Get Lens Option Name By Id
     * @param $optionId
     * @return array|mixed|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getLensOptionName($optionId)
    {
        $option = $this->lensOptionFactory->create()->addAttributeToSelect('*')
                                                    ->setStoreId($this->getStoreId())
                                                    ->addAttributeToFilter('entity_id', $optionId)->getFirstItem();
        if ($option->getData('title') == '') {
            return 'null_data';
        }
        return $option->getData('title');
    }

    /**
     * Get lens condition for jsTree
     *
     * @return false|string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getLensCondition()
    {
        $res = [
            [
                'id' => 'conditionRoot',
                'parent' => '#',
                'text' => 'Begin',
                "state" => ["opened" => true]
            ]
        ];

        $conditionId = $this->getConditionId();
        if (!$conditionId) {
            return json_encode($res);
        }

        $conditionCollection = $this->lensConditionFactory->create()
                                    ->addAttributeToSelect('*')
                                    ->setStoreId($this->getStoreId())
                                    ->addAttributeToFilter('entity_id', $conditionId);

        foreach ($conditionCollection as $item) {
            $data = json_decode($item->getData('condition_value'));
            if (!$data) {
                return json_encode($res);
            }
            foreach ($data as $child) {
                $node = [
                    'id' => $child->id,
                    'parent' => $child->parent,
                    'text' => $child->li_attr->type == 'step' ?
                        $this->getLensStepName($child->li_attr->entity_id) :
                        $this->getLensOptionName($child->li_attr->entity_id),
                    'li_attr' => $child->li_attr
                ];
                array_push($res, $node);
            }
        }

        return json_encode($res);
    }
}
