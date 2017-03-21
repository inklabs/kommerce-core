<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionValueCommand;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteOptionValueHandler implements CommandHandlerInterface
{
    /** @var DeleteOptionValueCommand */
    private $command;

    /** @var OptionValueRepositoryInterface */
    private $optionValueRepository;

    public function __construct(
        DeleteOptionValueCommand $command,
        OptionValueRepositoryInterface $optionValueRepository
    ) {
        $this->command = $command;
        $this->optionValueRepository = $optionValueRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $optionValue = $this->optionValueRepository->findOneById(
            $this->command->getOptionValueId()
        );
        $this->optionValueRepository->delete($optionValue);
    }
}
