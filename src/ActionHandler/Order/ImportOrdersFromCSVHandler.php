<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrdersFromCSVCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportOrderServiceInterface;

final class ImportOrdersFromCSVHandler implements CommandHandlerInterface
{
    /** @var ImportOrdersFromCSVCommand */
    private $command;

    /** @var ImportOrderServiceInterface */
    private $importOrderService;

    public function __construct(
        ImportOrdersFromCSVCommand $command,
        ImportOrderServiceInterface $importOrderService
    ) {
        $this->command = $command;
        $this->importOrderService = $importOrderService;
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

        $this->importOrderService->import($iterator);
    }
}
