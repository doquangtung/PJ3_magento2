<?php
declare(strict_types=1);

namespace Bss\LensSystem\Api;

interface LensManagementInterface
{
    /**
     * GET lens condition by SKU
     * @param string $sku
     * @return string
     */
    public function getLensBySku(string $sku);

    /**
     * Return data about selected option and signature
     * @return mixed
     */
    public function verify();
}
