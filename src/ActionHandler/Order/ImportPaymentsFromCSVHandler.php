<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportPaymentsFromCSVCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportPaymentServiceInterface;

final class ImportPaymentsFromCSVHandler implements CommandHandlerInterface
{
    /** @var ImportPaymentsFromCSVCommand */
    private $command;

    /** @var ImportPaymentServiceInterface */
    private $importPaymentService;

    public function __construct(
        ImportPaymentsFromCSVCommand $command,
        ImportPaymentServiceInterface $importPaymentService
    ) {
        $this->command = $command;
        $this->importPaymentService = $importPaymentService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $iterator = new CSVIterator(
            $this->command->getFileName()
        );

        $this->importPaymentService->import($iterator);
    }
}
