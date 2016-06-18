<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportUserServiceInterface
{
    /**
     * @param Iterator $iterator
     * @return ImportResult
     */
    public function import(Iterator $iterator);
}
