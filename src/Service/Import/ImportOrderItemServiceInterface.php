<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportOrderItemServiceInterface
{
    /**
     * @param Iterator $iterator
     * @return ImportResult
     */
    public function import(Iterator $iterator);
}
