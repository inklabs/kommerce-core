<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\tests\Helper\TestCase\KommerceTestCase;

class ImportResultTest extends KommerceTestCase
{
    public function testCreate()
    {
        $importResult = new ImportResult;
        $importResult->incrementSuccess();
        $importResult->addFailedRow(['test']);
        $importResult->addErrorMessage('error message');

        $this->assertSame(1, $importResult->getSuccessCount());
        $this->assertSame(1, $importResult->getFailedCount());
        $this->assertSame([['test']], $importResult->getFailedRows());
        $this->assertSame(['error message'], $importResult->getErrorMessages());
    }
}
