<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportOrderServiceInterface
{
    public function import(Iterator $iterator): ImportResult;
}
