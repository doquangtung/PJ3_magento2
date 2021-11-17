<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\Import\LensesImport;

interface RowValidatorInterface extends \Magento\Framework\Validator\ValidatorInterface
{
    const ERROR_INVALID_TITLE= 'InvalidValueTITLE';
    const ERROR_MESSAGE_IS_EMPTY = 'EmptyMessage';
    /**
     * Initialize validator
     *
     * @return $this
     */
    public function init($context);
}
