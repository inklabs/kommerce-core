<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateOptionHandler implements CommandHandlerInterface
{
    /** @var CreateOptionCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    public function __construct(
        CreateOptionCommand $command,
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
        $option = OptionDTOBuilder::createFromDTO(
            $this->command->getOptionId(),
            $this->command->getOptionDTO()
        );
        $this->optionRepository->create($option);
    }
}
