<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model;

use Bss\LensSystem\Model\ResourceModel\LensSteps\CollectionFactory;
use Exception;
use Magento\Catalog\Model\AbstractModel;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Store\Model\StoreManagerInterface;

/**
 * class LensManagement
 * Manager data for lens api
 */
class LensManagement
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var CollectionFactory
     */
    protected $lensStepFactory;

    /**
     * @var ResourceModel\LensOptions\CollectionFactory
     */
    protected $lensOptionFactory;

    /**
     * @var ResourceModel\LensCondition\CollectionFactory
     */
    protected $lensConditionFactory;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * LensManagement constructor.
     * @param ProductFactory $productFactory
     * @param ResourceModel\LensSteps\CollectionFactory $lensStepFactory
     * @param ResourceModel\LensOptions\CollectionFactory $lensOptionFactory
     * @param ResourceModel\LensCondition\CollectionFactory $lensConditionFactory
     * @param Request $request
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ProductFactory $productFactory,
        CollectionFactory $lensStepFactory,
        ResourceModel\LensOptions\CollectionFactory $lensOptionFactory,
        ResourceModel\LensCondition\CollectionFactory $lensConditionFactory,
        Request $request,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->productFactory = $productFactory;
        $this->lensStepFactory = $lensStepFactory;
        $this->lensOptionFactory = $lensOptionFactory;
        $this->lensConditionFactory = $lensConditionFactory;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get lens condition id by product sku
     * @param $sku
     * @return bool|AbstractModel
     */
    public function getConditionIdBySku($sku)
    {
        try {
            $product = $this->productFactory->create()->loadByAttribute('sku', $sku);
            if ($product) {
                $condition = $product->getCustomAttribute('condition_dropdown');
                return $condition ? $condition->getValue() : false;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    /**
     * Get full condition detail for api
     * @param $sku
     * @return array
     * @throws LocalizedException
     */
    public function getConditionDetail($sku)
    {
        $conditionId = $this->getConditionIdBySku($sku);
        if (!$conditionId) {
            throw new NotFoundException(__('Invalid SKU'));
        }
        $condition = $this->lensConditionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', $conditionId)
            ->getFirstItem();
        $data = $this->initData(json_decode($condition->getData('condition_value')));
        $res = $this->buildDataTree($data);
        $res = reset($res);

        return [
            'mode' => $condition->getData('condition_mode'),
            'name' => $condition->getData('condition_title'),
            'begin' => $res
        ];
    }

    /**
     * Get step info by step id
     * @param $stepId
     * @param $stepInfo
     * @return array
     * @throws LocalizedException
     */
    public function getStepInfo($stepId, $stepInfo)
    {
        $lensStep = $this->lensStepFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', $stepId)
            ->getFirstItem();
        try {
            $stepInfo['id'] = $lensStep->getData('step_id');
            $stepInfo['title'] = $lensStep->getData('step_title');
            $stepInfo['instruction'] = $lensStep->getData('instru');
            $stepInfo['layout'] = $lensStep->getData('layout');
        } catch (Exception $e) {
            return $stepInfo;
        }

        return $stepInfo;
    }

    /**
     * Check if options has this key data
     * @param $lensOption
     * @param $key
     * @return bool
     */
    public function isHasData($lensOption, $key)
    {
        if ($lensOption->getData($key) && $lensOption->getData($key) != ' ') {
            return true;
        }

        return false;
    }

    /**
     * Get option info by option id
     * @param $optionId
     * @param $optionPrice
     * @param $optionInfo
     * @return array
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getOptionInfo($optionId, $optionPrice, $optionInfo)
    {
        $lensOption = $this->lensOptionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', $optionId)
            ->getFirstItem();
        try {
            $optionInfo['id'] = $lensOption->getData('option_id');
            $optionInfo['title'] = $lensOption->getData('title');
            if ($this->isHasData($lensOption, 'description')) {
                $optionInfo['description'] = $lensOption->getData('description');
            }
            if ($this->isHasData($lensOption, 'description_short')) {
                $optionInfo['description_short'] = $lensOption->getData('description_short');
            }
            $optionInfo['price'] = (int) $optionPrice;
            if ($this->isHasData($lensOption, 'tooltip_title')
                || $this->isHasData($lensOption, 'tooltip_image')
                || $this->isHasData($lensOption, 'tooltip_body')
            ) {
                $optionInfo['tooltip'] = [
                    'title' => $lensOption->getData('tooltip_title'),
                    'image' => $lensOption->getData('tooltip_image'),
                    'body' => $lensOption->getData('tooltip_body')
                ];
            }
            if ($lensOption->getData('image')) {
                $optionInfo['image'] = $lensOption->getData('image');
            }
            if ($lensOption->getData('image_invert')) {
                $optionInfo['image_invert'] = $lensOption->getData('image_invert');
            }
            if ($lensOption->getData('overlay_image')) {
                $optionInfo['overlay_image'] = $lensOption->getData('overlay_image');
            }
        } catch (Exception $e) {
            return $optionInfo;
        }

        return $optionInfo;
    }

    /**
     * @param $condition
     * @return array
     * @throws LocalizedException
     */
    public function initData($condition)
    {
        if (!$condition) {
            return [];
        }
        $res = [];
        foreach ($condition as $child) {
            $node = [
                '_id' => $child->id,
                'parent' => $child->parent,
                'type' => $child->li_attr->type,
                'entity_id' => $child->li_attr->entity_id
            ];
            if ($child->li_attr->type == 'step') {
                $node = $this->getStepInfo($child->li_attr->entity_id, $node);
            } else {
                $node = $this->getOptionInfo($child->li_attr->entity_id, $child->li_attr->price, $node);
                if (array_key_exists('included', $child->li_attr)) {
                    $node['included'] = $child->li_attr->included;
                }
            }

            if ($node['id']) {
                array_push($res, $node);
            }
        }

        return $res;
    }

    /**
     * Build data lens condition tree
     * @param array $elements
     * @param int $parentId
     * @param int $depth
     * @return array
     */
    public function buildDataTree(array &$elements, $parentId = 0, $depth = 0)
    {
        $branch = [];
        foreach ($elements as &$element) {
            if ($element['parent'] == $parentId) {
                $children = $this->buildDataTree($elements, $element['_id'], $depth + 1);
                if ($children) {
                    if ($element['type'] == 'option') {
                        $element['next'] = array_values($children)[0];
                    } else {
                        $element['options'] = array_values($children);
                        $element['depth'] = $depth / 2;
                    }
                } else {
                    if ($element['type'] == 'option') {
                        $element['next'] = 'checkout';
                    }
                }
                $branch[$element['_id']] = $element;
                unset($element);
            }
        }

        return $branch;
    }

    /**
     * Remove unnecessary field in api response
     */
    public function recursiveUnset(&$array)
    {
        unset($array['_id']);
        unset($array['parent']);
        unset($array['type']);
        unset($array['entity_id']);
        if (array_key_exists('price', $array) && $array['price'] == 0 &&
            array_key_exists('included', $array) && !$array['included']) {
            unset($array['price']);
        }
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursiveUnset($value);
            }
        }
    }

    /**
     * @param $sku
     * @return string
     * @throws LocalizedException
     */
    public function getLensBySku($sku = null)
    {
        $data = $this->getConditionDetail($sku);
        $this->recursiveUnset($data);

        return json_encode($data);
    }

    /**
     * Get list store for translate data
     * @return array
     */
    public function getStoreCodeList()
    {
        $storeList = $this->storeManager->getStores();
        $result = [];
        foreach ($storeList as $key => $value) {
            switch ($value['code']) {
                case 'en':
                    $result['en'] = $key;
                    break;
                case 'ca_fr':
                    $result['cn'] = $key;
                    break;
                case 'zh_hant_tw':
                    $result['hk'] = $key;
                    break;
                case 'co_french':
                    $result['fr'] = $key;
                    break;
                case 'bs_de':
                    $result['de'] = $key;
                    break;
            }
        }
        return $result;
    }

    /**
     * Get translation by step id
     * @param $stepId
     * @return array
     * @throws LocalizedException
     */
    public function getTranslateStep($stepId)
    {
        try {
            $storeList = $this->getStoreCodeList();
            $result = [];
            foreach ($storeList as $storeCode => $storeId) {
                $lensStep = $this->lensStepFactory->create()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', $stepId)
                    ->setStoreId($storeId)->getFirstItem();
                $result[$storeCode] = $lensStep->getData('step_title');
            }
        } catch (Exception $e) {
            throw new NotFoundException(__('Can\'nt get step.'));
        }

        return $result;
    }

    /**
     * Get translation of option by option id
     * @param $optionId
     * @return array
     * @throws NotFoundException
     */
    public function getTranslateOption($optionId)
    {
        try {
            $storeList = $this->getStoreCodeList();
            $result = [];
            foreach ($storeList as $storeCode => $storeId) {
                $lensOption = $this->lensOptionFactory->create()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', $optionId)
                    ->setStoreId($storeId)->getFirstItem();
                $result[$storeCode] = $lensOption->getData('title');
            }
        } catch (Exception $e) {
            throw new NotFoundException(__('Can\'nt get step.'));
        }

        return $result;
    }

    /**
     * Return signature of data selected option
     * @param $data
     * @return string
     */
    public function signature($data)
    {
        $privateKey = $this->scopeConfig->getValue('k2digital_glassesgallery_add_lens/general/lens_private_key');

        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    /**
     * Return translate of selected option and signature
     * @throws NotFoundException
     */
    public function verify()
    {
        $body = $this->request->getBodyParams();

        try {
            $sku = $body['sku'];
            $selectedOptions = $body['selectedOptions'];
            $selectedOptionsPrice = [];
            $upgradePreselect = [];
            $upgradeOpts = [];
            $upgradeCost = 0;
            $translation = [];
            $dataTranslate = [];
            $stepArr = [];
            $optionArr = [];

            // Condition data of this product
            $data = $this->getConditionDetail($sku)['begin'];
            // Get entity_id of each selected option
            foreach ($selectedOptions as $key => $value) {
                if ($data['id'] === $key) {
                    $options = $data['options'];
                    foreach ($options as $option) {
                        if ($option['id'] == $value) {
                            $dataTranslate[$data['entity_id']] = $option['entity_id'];
                            $selectedOptionsPrice[$option['id']] = (int) $option['price'];
                            $upgradeCost += (int) $option['price'];
                            $stepArr[$data['entity_id']] = $data['id'];
                            $optionArr[$option['entity_id']] = $option['id'];
                            $data = $option['next'];
                            break;
                        }
                    }
                } else {
                    $dataTranslate = [];
                    break;
                }
            }

            if (!$dataTranslate) {
                throw new NotFoundException(__('Invalid data'));
            }

            foreach ($dataTranslate as $stepId => $optionId) {
                $translation[$stepArr[$stepId]] = $this->getTranslateStep($stepId);
                $translation[$optionArr[$optionId]] = $this->getTranslateOption($optionId);
            }

            $dataString = json_encode([
                'sku' => $sku,
                'selected_options' => $selectedOptions,
                'selected_options_price' => $selectedOptionsPrice,
                'upgrade_preselect' => array_values($upgradePreselect),
                'upgrade_opts' => array_values($upgradeOpts),
                'upgrade_cost' => $upgradeCost,
                'translations' => $translation
            ]);

            $response = [
                'data' => $dataString,
                'signature' => $this->signature($dataString)
            ];
        } catch (Exception $e) {
            throw new NotFoundException(__('Invalid data'));
        }
        return json_encode($response);
    }
}
