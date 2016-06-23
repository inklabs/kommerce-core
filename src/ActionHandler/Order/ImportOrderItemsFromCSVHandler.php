<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrderItemsFromCSVCommand;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportOrderItemServiceInterface;

final class ImportOrderItemsFromCSVHandler
{
    /** @var ImportOrderItemServiceInterface */
    private $importOrderItemService;

    public function __construct(ImportOrderItemServiceInterface $importOrderItemService)
    {
        $this->importOrderItemService = $importOrderItemService;
    }

    public function handle(ImportOrderItemsFromCSVCommand $command)
    {
        $iterator = new CSVIterator(
            $command->getFileName()
        );

        $this->importOrderItemService->import($iterator);
    }
}
