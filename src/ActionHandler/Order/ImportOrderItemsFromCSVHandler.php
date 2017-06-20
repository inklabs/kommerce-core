<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrderItemsFromCSVCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportOrderItemServiceInterface;

final class ImportOrderItemsFromCSVHandler implements CommandHandlerInterface
{
    /** @var ImportOrderItemsFromCSVCommand */
    private $command;

    /** @var ImportOrderItemServiceInterface */
    private $importOrderItemService;

    public function __construct(
        ImportOrderItemsFromCSVCommand $command,
        ImportOrderItemServiceInterface $importOrderItemService
    ) {
        $this->command = $command;
        $this->importOrderItemService = $importOrderItemService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $iterator = new CSVIterator(
            $this->command->getFileName()
        );

        $this->importOrderItemService->import($iterator);
    }
}
