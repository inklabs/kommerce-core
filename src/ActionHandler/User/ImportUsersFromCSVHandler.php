<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\Event\ImportedUsersFromCSVEvent;
use inklabs\kommerce\Event\RaiseEventTrait;
use inklabs\kommerce\Event\ReleaseEventsInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportUserServiceInterface;

final class ImportUsersFromCSVHandler implements CommandHandlerInterface, ReleaseEventsInterface
{
    use RaiseEventTrait;

    /** @var ImportUsersFromCSVCommand */
    private $command;

    /** @var ImportUserServiceInterface */
    private $importUserService;

    public function __construct(ImportUsersFromCSVCommand $command, ImportUserServiceInterface $importUserService)
    {
        $this->command = $command;
        $this->importUserService = $importUserService;
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

        $importResult = $this->importUserService->import($iterator);

        $this->raiseEvent(ImportedUsersFromCSVEvent::createFromImportResult($importResult));
    }
}
