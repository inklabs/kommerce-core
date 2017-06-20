<?php
namespace inklabs\kommerce\Service\Import;

use Iterator;

interface ImportPaymentServiceInterface
{
    public function import(Iterator $iterator): ImportResult;
}
