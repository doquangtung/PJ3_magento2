<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\Import;

use Bss\LensSystem\Model\Import\LensesImport\RowValidatorInterface as ValidatorInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;

/**
 * Class Model for Lenses Import
 */
class LensesImport extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    const ID = 'id';
    const ACTIVE = 'active';
    const SERIAL = 'serial';
    const EYEWEAR_TYPE = 'eyewear_type';
    const LENS_TYPE = 'lens_type';
    const LENS_FUNC = 'lens_func';
    const LENS_PKG = 'lens_pkg';
    const LENS_COLOR = 'lens_color';
    const SELECTED_UPGRADE_OPTIONS = 'selected_upgrade_options';
    const LENS_INDEX = 'lens_index';
    const LENS_GROUP = 'lens_group';
    const LENS_CODE = 'lens_code';
    const COATING_NAME = 'coating_name';
    const COATING_CODE = 'coating_code';
    const TINT_COLOR_CODE = 'tint_color_code';
    const LENS_ABSORPTION = 'lens_absorption';
    const LENS_DIAMETER = 'lens_diameter';
    const AVAILABLE_DIAMETER = 'available_diameter';
    const POWER_MINUS_LOWER = 'power_minus_lower';
    const POWER_MINUS_HIGHER = 'power_minus_higher';
    const POWER_PLUS_LOWER = 'power_plus_lower';
    const POWER_PLUS_HIGHER = 'power_plus_higher';
    const CYL_MINUS_LOWER = 'cyl_minus_lower';
    const CYL_MINUS_HIGHER = 'cyl_minus_higher';
    const CYL_PLUS_LOWER = 'cyl_plus_lower';
    const CYL_PLUS_HIGHER = 'cyl_plus_higher';
    const ADD_MIN = 'add_min';
    const ADD_MAX = 'add_max';
    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = [
        ValidatorInterface::ERROR_MESSAGE_IS_EMPTY => 'Message is empty',
    ];
    /**
     * @var string[]
     */
    protected $_permanentAttributes = [self::ID];
    /**
     * If we should check column names
     *
     * @var bool
     */
    protected $needColumnCheck = true;
    /**
     * Valid column names
     *
     * @array
     */
    protected $validColumnNames = [
        self::ID,
        self::ACTIVE,
        self::SERIAL,
        self::EYEWEAR_TYPE,
        self::LENS_TYPE,
        self::LENS_FUNC,
        self::LENS_PKG,
        self::LENS_COLOR,
        self::SELECTED_UPGRADE_OPTIONS,
        self::LENS_INDEX,
        self::LENS_GROUP,
        self::LENS_CODE,
        self::COATING_NAME,
        self::COATING_CODE,
        self::TINT_COLOR_CODE,
        self::LENS_ABSORPTION,
        self::LENS_DIAMETER,
        self::AVAILABLE_DIAMETER,
        self::POWER_MINUS_LOWER,
        self::POWER_MINUS_HIGHER,
        self::POWER_PLUS_LOWER,
        self::POWER_PLUS_HIGHER,
        self::CYL_MINUS_LOWER,
        self::CYL_MINUS_HIGHER,
        self::CYL_PLUS_LOWER,
        self::CYL_PLUS_HIGHER,
        self::ADD_MIN,
        self::ADD_MAX
    ];
    /**
     * Need to log in import history
     *
     * @var bool
     */
    protected $logInHistory = true;
    /**
     * @var array
     */
    protected $_validators = [];
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_connection;
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\ImportExport\Helper\Data $importExportData
     * @param \Magento\ImportExport\Model\ResourceModel\Import\Data $importData
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param ProcessingErrorAggregatorInterface $errorAggregator
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     * @phpstan-ignore-next-line
     */
    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        ProcessingErrorAggregatorInterface $errorAggregator
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->_importExportData = $importExportData;
        $this->_resourceHelper = $resourceHelper;
        $this->_dataSourceModel = $importData;
        $this->_resource = $resource;
        $this->_connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $this->errorAggregator = $errorAggregator;
    }

    /**
     * @return array|string[]
     */
    public function getValidColumnNames()
    {
        return $this->validColumnNames;
    }

    /**
     * Entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'lenssystem_lenses';
    }

    /**
     * Row validation.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validateRow(array $rowData, $rowNum)
    {
        if (isset($this->_validatedRows[$rowNum])) {
            return !$this->getErrorAggregator()->isRowInvalid($rowNum);
        }
        $this->_validatedRows[$rowNum] = true;
        return !$this->getErrorAggregator()->isRowInvalid($rowNum);
    }

    /**
     * Create Advanced message data from raw data.
     *
     * @return bool Result of operation.
     * @throws \Exception
     */
    protected function _importData()
    {
        $this->saveEntity();
        return true;
    }

    /**
     * Save Message
     *
     * @return $this
     */
    public function saveEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }

    /**
     * Save and replace data message
     *
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function saveAndReplaceEntity()
    {
        $behavior = $this->getBehavior();
        $listTitle = [];
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            $entityList = [];
            foreach ($bunch as $rowNum => $rowData) {
                if (!$this->validateRow($rowData, $rowNum)) {
                    $this->addRowError(ValidatorInterface::ERROR_INVALID_TITLE, $rowNum);
                    continue;
                }
                if ($this->getErrorAggregator()->hasToBeTerminated()) {
                    $this->getErrorAggregator()->addRowToSkip($rowNum);
                    continue;
                }
                $rowTtile = $rowData[self::ID];
                $listTitle[] = $rowTtile;
                $entityList[$rowTtile][] = [
                    self::ID => $rowData[self::ID],
                    self::ACTIVE => $rowData[self::ACTIVE],
                    self::SERIAL => $rowData[self::SERIAL],
                    self::EYEWEAR_TYPE => $rowData[self::EYEWEAR_TYPE],
                    self::LENS_TYPE => $rowData[self::LENS_TYPE],
                    self::LENS_FUNC => $rowData[self::LENS_FUNC],
                    self::LENS_PKG => $rowData[self::LENS_PKG],
                    self::LENS_COLOR => $rowData[self::LENS_COLOR],
                    self::SELECTED_UPGRADE_OPTIONS => $rowData[self::SELECTED_UPGRADE_OPTIONS],
                    self::LENS_INDEX => $rowData[self::LENS_INDEX],
                    self::LENS_GROUP => $rowData[self::LENS_GROUP],
                    self::LENS_CODE => $rowData[self::LENS_CODE],
                    self::COATING_NAME => $rowData[self::COATING_NAME],
                    self::COATING_CODE => $rowData[self::COATING_CODE],
                    self::TINT_COLOR_CODE => $rowData[self::TINT_COLOR_CODE],
                    self::LENS_ABSORPTION => $rowData[self::LENS_ABSORPTION],
                    self::LENS_DIAMETER => $rowData[self::LENS_DIAMETER],
                    self::AVAILABLE_DIAMETER => $rowData[self::AVAILABLE_DIAMETER],
                    self::POWER_MINUS_LOWER => $rowData[self::POWER_MINUS_LOWER],
                    self::POWER_MINUS_HIGHER => $rowData[self::POWER_MINUS_HIGHER],
                    self::POWER_PLUS_LOWER => $rowData[self::POWER_PLUS_LOWER],
                    self::POWER_PLUS_HIGHER => $rowData[self::POWER_PLUS_HIGHER],
                    self::CYL_MINUS_LOWER => $rowData[self::CYL_MINUS_LOWER],
                    self::CYL_MINUS_HIGHER => $rowData[self::CYL_MINUS_HIGHER],
                    self::CYL_PLUS_LOWER => $rowData[self::CYL_PLUS_LOWER],
                    self::CYL_PLUS_HIGHER => $rowData[self::CYL_PLUS_HIGHER],
                    self::ADD_MIN => $rowData[self::ADD_MIN],
                    self::ADD_MAX => $rowData[self::ADD_MAX]
                ];
            }
            if (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $behavior) {
                $this->saveEntityFinish($entityList, 'lenssystem_lenses');
            }
        }
        return $this;
    }

    /**
     * Save message to customtable.
     *
     * @param array $priceData
     * @param string $table
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function saveEntityFinish(array $entityData, $table)
    {
        if ($entityData) {
            $tableName = $this->_connection->getTableName($table);
            $entityIn = [];
            foreach ($entityData as $id => $entityRows) {
                foreach ($entityRows as $row) {
                    $entityIn[] = $row;
                }
            }
            if ($entityIn) {
                $this->_connection->insertOnDuplicate($tableName, $entityIn, [
                    self::ID,
                    self::ACTIVE,
                    self::SERIAL,
                    self::EYEWEAR_TYPE,
                    self::LENS_TYPE,
                    self::LENS_FUNC,
                    self::LENS_PKG,
                    self::LENS_COLOR,
                    self::SELECTED_UPGRADE_OPTIONS,
                    self::LENS_INDEX,
                    self::LENS_GROUP,
                    self::LENS_CODE,
                    self::COATING_NAME,
                    self::COATING_CODE,
                    self::TINT_COLOR_CODE,
                    self::LENS_ABSORPTION,
                    self::LENS_DIAMETER,
                    self::AVAILABLE_DIAMETER,
                    self::POWER_MINUS_LOWER,
                    self::POWER_MINUS_HIGHER,
                    self::POWER_PLUS_LOWER,
                    self::POWER_PLUS_HIGHER,
                    self::CYL_MINUS_LOWER,
                    self::CYL_MINUS_HIGHER,
                    self::CYL_PLUS_LOWER,
                    self::CYL_PLUS_HIGHER,
                    self::ADD_MIN,
                    self::ADD_MAX
                ]);
            }
        }
        return $this;
    }
}
