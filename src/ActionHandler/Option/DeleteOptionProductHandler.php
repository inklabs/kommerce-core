<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionProductCommand;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteOptionProductHandler implements CommandHandlerInterface
{
    /** @var DeleteOptionProductCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var OptionProductRepositoryInterface */
    private $optionProductRepository;

    public function __construct(
        DeleteOptionProductCommand $command,
        OptionRepositoryInterface $optionRepository,
        OptionProductRepositoryInterface $optionProductRepository
    ) {
        $this->command = $command;
        $this->optionRepository = $optionRepository;
        $this->optionProductRepository = $optionProductRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $optionProduct = $this->optionRepository->getOptionProductById($this->command->getOptionProductId());
        $this->optionProductRepository->delete($optionProduct);
    }
}
