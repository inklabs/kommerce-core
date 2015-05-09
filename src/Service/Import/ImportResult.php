<?php
namespace inklabs\kommerce\Service\Import;

class ImportResult
{
    /** @var int */
    private $successCount = 0;

    /** @var array */
    private $failedRows = [];

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getFailedCount()
    {
        return count($this->failedRows);
    }

    public function incrementSuccess()
    {
        $this->successCount++;
    }

    public function getFailedRows()
    {
        return $this->failedRows;
    }

    public function addFailedRow(array $failedRow)
    {
        $this->failedRows[] = $failedRow;
    }
}
