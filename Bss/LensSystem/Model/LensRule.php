<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Model\ResourceModel\LensRule as LensRuleResourceModel;
use Magento\Quote\Model\Quote\Address;
use Magento\Rule\Model\AbstractModel;

/**
 * Lens Rule Model
 */
class LensRule extends AbstractModel implements \Bss\LensSystem\Api\Data\LensDiscountInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'Bss_LensSystem';

    /**
     * @var string
     */
    protected $_eventObject = 'rule';

    /**
     * @var \Magento\CatalogRule\Model\Rule\Condition\CombineFactory
     */
    protected $condCombineFactory;

    /**
     * @var \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory
     */
    protected $condProdCombineF;

    /**
     * @var array
     */
    protected $validatedAddresses = [];

    /**
     * Array products match rule
     */
    protected $selectProductIds;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $productCollectionFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $condCombineFactory
     * @param \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory $condProdCombineF
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $condCombineFactory,
        \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory $condProdCombineF,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory ,
        array $data = []
    ) {
        $this->condCombineFactory = $condCombineFactory;
        $this->condProdCombineF = $condProdCombineF;
        $this->productCollectionFactory = $productCollectionFactory;

        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data);
    }

    /**
     * Protected construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(LensRuleResourceModel::class);
        $this->setIdFieldName('rule_id');
    }

    /**
     * @return \Magento\CatalogRule\Model\Rule\Condition\Combine|\Magento\Rule\Model\Condition\Combine
     */
    public function getConditionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    /**
     * @return \Magento\CatalogRule\Model\Rule\Condition\Combine|\Magento\Rule\Model\Action\Collection
     */
    public function getActionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    /**
     * @param $address
     * @return bool
     */
    public function hasIsValidForAddress($address)
    {
        $addressId = $this->_getAddressId($address);
        return isset($this->validatedAddresses[$addressId]) ? true : false;
    }

    /**
     * @param $address
     * @param $validationResult
     * @return $this
     */
    public function setIsValidForAddress($address, $validationResult)
    {
        $addressId = $this->_getAddressId($address);
        $this->validatedAddresses[$addressId] = $validationResult;
        return $this;
    }

    /**
     * @param $address
     * @return false|mixed
     */
    public function getIsValidForAddress($address)
    {
        $addressId = $this->_getAddressId($address);
        return isset($this->validatedAddresses[$addressId]) ? $this->validatedAddresses[$addressId] : false;
    }

    /**
     * @param $address
     * @return mixed
     */
    private function _getAddressId($address)
    {
        if ($address instanceof Address) {
            return $address->getId();
        }
        return $address;
    }

    /**
     * @param string $formName
     * @return string
     */
    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    /**
     * @param string $formName
     * @return string
     */
    public function getActionFieldSetId($formName = '')
    {
        return $formName . 'rule_actions_fieldset_' . $this->getId();
    }

    /**
     * @return array
     */
    public function getMatchProductIds()
    {
        $productCollection = $this->productCollectionFactory->create();
        $productFactory = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Catalog\Model\ProductFactory'
        );
        $this->selectProductIds = [];
        $this->setCollectedAttributes([]);
        $this->getConditions()->collectValidatedAttributes($productCollection);
        \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Framework\Model\ResourceModel\Iterator'
        )->walk(
            $productCollection->getSelect(),
            [[$this, 'callbackValidateProductCondition']],
            [
                'attributes' => $this->getCollectedAttributes(),
                'product' => $productFactory->create(),
            ]
        );
        return $this->selectProductIds;
    }

    /**
     * @param $args
     */
    public function callbackValidateProductCondition($args)
    {
        $product = clone $args['product'];
        $product->setData($args['row']);
        $websites = $this->_getWebsitesMap();
        foreach ($websites as $websiteId => $defaultStoreId) {
            $product->setStoreId($defaultStoreId);
            if ($this->getConditions()->validate($product)) {
                $this->selectProductIds[] = $product->getId();
            }
        }
    }

    /**
     * @return array
     */
    protected function _getWebsitesMap()
    {
        $map = [];
        $websites = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Store\Model\StoreManagerInterface'
        )->getWebsites();
        foreach ($websites as $website) {
            if ($website->getDefaultStore() === null) {
                continue;
            }
            $map[$website->getId()] = $website->getDefaultStore()->getId();
        }
        return $map;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData('rule_id');
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->getData('rule_name');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setName($value)
    {
        return $this->setData('rule_name', $value);
    }

    /**
     * @return mixed|null
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setDescription($value)
    {
        return $this->setData('description', $value);
    }

    /**
     * @return mixed|null
     */
    public function getFromDate()
    {
        return $this->getData('from_date');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setFromDate($value)
    {
        return $this->setData('from_date', $value);
    }

    /**
     * @return mixed|null
     */
    public function getToDate()
    {
        return $this->getData('to_date');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setToDate($value)
    {
        return $this->setData('to_date', $value);
    }

    /**
     * @return mixed|null
     */
    public function getIsActive()
    {
        return $this->getData('is_active');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setIsActive($value)
    {
        return $this->setData('is_active', $value);
    }

    /**
     * @return mixed|null
     */
    public function getRule()
    {
        return $this->getData('conditions_serialized');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setRule($value)
    {
        return $this->setData('conditions_serialized', $value);
    }

    /**
     * @return mixed|null
     */
    public function getSortOrder()
    {
        return $this->getData('sort_order');
    }

    /**
     * @param $value
     * @return LensRule
     */
    public function setSortOrder($value)
    {
        return $this->setData('sort_order', $value);
    }
}
