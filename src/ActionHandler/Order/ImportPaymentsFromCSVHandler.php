<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportPaymentsFromCSVCommand;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportPaymentServiceInterface;

final class ImportPaymentsFromCSVHandler
{
    /** @var ImportPaymentServiceInterface */
    private $importPaymentService;

    public function __construct(ImportPaymentServiceInterface $importPaymentService)
    {
        $this->importPaymentService = $importPaymentService;
    }

    public function handle(ImportPaymentsFromCSVCommand $command)
    {
        $iterator = new CSVIterator(
            $command->getFileName()
        );

        $this->importPaymentService->import($iterator);
    }
}
