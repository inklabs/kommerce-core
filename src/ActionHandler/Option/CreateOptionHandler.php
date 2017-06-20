<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionCommand;
use inklabs\kommerce\Entity\Option;
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

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $option = new Option($this->command->getOptionId());
        $option->setName($this->command->getName());
        $option->setDescription($this->command->getDescription());
        $option->setSortOrder($this->command->getSortOrder());
        $option->setType($this->command->getOptionType());

        $this->optionRepository->create($option);
    }
}
