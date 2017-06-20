<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportOrderItemServiceInterface
{
    public function import(Iterator $iterator): ImportResult;
}
