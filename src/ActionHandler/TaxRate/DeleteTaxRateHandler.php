<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\DeleteTaxRateCommand;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteTaxRateHandler implements CommandHandlerInterface
{
    /** @var DeleteTaxRateCommand */
    private $command;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    public function __construct(DeleteTaxRateCommand $command, TaxRateRepositoryInterface $taxRateRepository)
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
        $taxRate = $this->taxRateRepository->findOneById(
            $this->command->getTaxRateId()
        );
        $this->taxRateRepository->delete($taxRate);
    }
}
