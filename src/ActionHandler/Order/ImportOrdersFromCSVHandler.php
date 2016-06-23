<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrdersFromCSVCommand;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportOrderServiceInterface;

final class ImportOrdersFromCSVHandler
{
    /** @var ImportOrderServiceInterface */
    private $importOrderService;

    public function __construct(ImportOrderServiceInterface $importOrderService)
    {
        $this->importOrderService = $importOrderService;
    }

    public function handle(ImportOrdersFromCSVCommand $command)
    {
        $iterator = new CSVIterator(
            $command->getFileName()
        );

        $this->importOrderService->import($iterator);
    }
}
