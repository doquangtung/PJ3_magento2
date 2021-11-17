<?php
declare(strict_types=1);

namespace Bss\LensSystem\Model\Import\FittingHeightImport;

interface RowValidatorInterface extends \Magento\Framework\Validator\ValidatorInterface
{
    const ERROR_INVALID_TITLE= 'InvalidValueTITLE';
    const ERROR_MESSAGE_IS_EMPTY = 'EmptyMessage';
    const ERROR_TITLE_IS_EMPTY = "Title Is Empty";
    /**
     * Initialize validator
     *
     * @return $this
     */
    public function init($context);
}
