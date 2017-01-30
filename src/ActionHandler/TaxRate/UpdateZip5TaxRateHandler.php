<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5TaxRateCommand;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateZip5TaxRateHandler implements CommandHandlerInterface
{
    /** @var UpdateZip5TaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(UpdateZip5TaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
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
        $taxRate->setState(null);
        $taxRate->setZip5From(null);
        $taxRate->setZip5To(null);
        $taxRate->setZip5($this->command->getZip5());
        $taxRate->setRate($this->command->getRate());
        $taxRate->setApplyToShipping($this->command->applyToShipping());

        $this->taxRateRepository->update($taxRate);
    }
}
