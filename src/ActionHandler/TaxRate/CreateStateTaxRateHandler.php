<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateStateTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateStateTaxRateHandler implements CommandHandlerInterface
{
    /** @var CreateStateTaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(CreateStateTaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
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
        $taxRate = TaxRate::createState(
            $this->command->getState(),
            $this->command->getRate(),
            $this->command->applyToShipping(),
            $this->command->getTaxRateId()
        );

        $this->taxRateRepository->create($taxRate);
    }
}
