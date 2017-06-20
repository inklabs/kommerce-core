<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateZip5TaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateZip5TaxRateHandler implements CommandHandlerInterface
{
    /** @var CreateZip5TaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(CreateZip5TaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
    {
        $this->command = $command;
        $this->taxRateRepository = $taxRateRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $taxRate = TaxRate::createZip5(
            $this->command->getZip5(),
            $this->command->getRate(),
            $this->command->applyToShipping(),
            $this->command->getTaxRateId()
        );

        $this->taxRateRepository->create($taxRate);
    }
}
