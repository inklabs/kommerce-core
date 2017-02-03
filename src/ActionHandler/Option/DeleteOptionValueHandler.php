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

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var OptionValueRepositoryInterface */
    private $optionValueRepository;

    public function __construct(
        DeleteOptionValueCommand $command,
        OptionRepositoryInterface $optionRepository,
        OptionValueRepositoryInterface $optionValueRepository
    ) {
        $this->command = $command;
        $this->optionRepository = $optionRepository;
        $this->optionValueRepository = $optionValueRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $optionValue = $this->optionRepository->getOptionValueById($this->command->getOptionValueId());
        $this->optionValueRepository->delete($optionValue);
    }
}
