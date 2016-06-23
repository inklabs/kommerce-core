<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportPaymentServiceInterface
{
    /**
     * @param Iterator $iterator
     * @return ImportResult
     */
    public function import(Iterator $iterator);
}
