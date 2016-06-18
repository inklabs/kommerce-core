<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\Service\Import\ImportUserServiceInterface;

final class ImportUsersFromCSVHandler
{
    /** @var ImportUserServiceInterface */
    private $importUserService;

    public function __construct(ImportUserServiceInterface $importUserService)
    {
        $this->importUserService = $importUserService;
    }

    public function handle(ImportUsersFromCSVCommand $command)
    {
        $iterator = new CSVIterator(
            $command->getFileName()
        );

        $this->importUserService->import($iterator);
    }
}
