<?php
namespace inklabs\kommerce\Service\Import;

class ImportResult
{
    /** @var int */
    private $successCount = 0;

    /** @var array[] */
    private $failedRows = [];

    /** @var string[] */
    private $errorMessages = [];

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getFailedCount(): int
    {
        return count($this->failedRows);
    }

    public function incrementSuccess(): void
    {
        $this->successCount++;
    }

    public function getFailedRows(): array
    {
        return $this->failedRows;
    }

    public function addFailedRow(array $failedRow): void
    {
        $this->failedRows[] = $failedRow;
    }

    public function addErrorMessage(string $errorMessage): void
    {
        $this->errorMessages[] = $errorMessage;
    }

    /**
     * @return string[]
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }
}
