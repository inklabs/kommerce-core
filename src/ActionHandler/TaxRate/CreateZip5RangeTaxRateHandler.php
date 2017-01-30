<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateZip5RangeTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateZip5RangeTaxRateHandler implements CommandHandlerInterface
{
    /** @var CreateZip5RangeTaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(CreateZip5RangeTaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
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
        $taxRate = TaxRate::createZip5Range(
            $this->command->getZip5From(),
            $this->command->getZip5To(),
            $this->command->getRate(),
            $this->command->applyToShipping(),
            $this->command->getTaxRateId()
        );

        $this->taxRateRepository->create($taxRate);
    }
}
