<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionCommand;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteOptionHandler implements CommandHandlerInterface
{
    /** @var DeleteOptionCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    public function __construct(
        DeleteOptionCommand $command,
        OptionRepositoryInterface $optionRepository
    ) {
        $this->command = $command;
        $this->optionRepository = $optionRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $option = $this->optionRepository->findOneById($this->command->getOptionId());
        $this->optionRepository->delete($option);
    }
}
