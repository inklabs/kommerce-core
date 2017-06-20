<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5RangeTaxRateCommand;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateZip5RangeTaxRateHandler implements CommandHandlerInterface
{
    /** @var UpdateZip5RangeTaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(UpdateZip5RangeTaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
    {
        $this->taxRateRepository = $taxRateRepository;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $taxRate = $this->taxRateRepository->findOneById($this->command->getTaxRateId());
        $taxRate->setZip5(null);
        $taxRate->setState(null);
        $taxRate->setZip5From($this->command->getZip5From());
        $taxRate->setZip5To($this->command->getZip5To());
        $taxRate->setRate($this->command->getRate());
        $taxRate->setApplyToShipping($this->command->applyToShipping());

        $this->taxRateRepository->update($taxRate);
    }
}
