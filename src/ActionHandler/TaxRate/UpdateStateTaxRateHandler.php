<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateStateTaxRateCommand;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateStateTaxRateHandler implements CommandHandlerInterface
{
    /** @var UpdateStateTaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(UpdateStateTaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
    {
        $this->command = $command;
        $this->taxRateRepository = $taxRateRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $taxRate = $this->taxRateRepository->findOneById($this->command->getTaxRateId());
        $taxRate->setZip5(null);
        $taxRate->setZip5From(null);
        $taxRate->setZip5To(null);
        $taxRate->setState($this->command->getState());
        $taxRate->setRate($this->command->getRate());
        $taxRate->setApplyToShipping($this->command->applyToShipping());

        $this->taxRateRepository->update($taxRate);
    }
}
