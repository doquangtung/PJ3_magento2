<?php
declare(strict_types=1);

namespace Bss\LensSystem\Ui\Component\Listing\DataProvider;

/**
 * Document Class
 * DataProvider Document UI
 */
class Document extends \Magento\Framework\View\Element\UiComponent\DataProvider\Document
{

    /**
     * @var string
     */
    protected $idFieldName = 'entity_id';

    /**
     * @return string
     */
    public function getIdFieldName()
    {
        return $this->idFieldName;
    }
}
