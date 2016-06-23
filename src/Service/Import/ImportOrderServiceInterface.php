<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportOrderServiceInterface
{
    /**
     * @param Iterator $iterator
     * @return ImportResult
     */
    public function import(Iterator $iterator);
}
