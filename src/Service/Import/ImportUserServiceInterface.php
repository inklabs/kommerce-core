<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportUserServiceInterface
{
    public function import(Iterator $iterator): ImportResult;
}
