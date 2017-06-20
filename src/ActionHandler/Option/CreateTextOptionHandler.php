<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateTextOptionCommand;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateTextOptionHandler implements CommandHandlerInterface
{
    /** @var CreateTextOptionCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var TextOptionRepositoryInterface */
    private $textOptionRepository;

    public function __construct(
        CreateTextOptionCommand $command,
        OptionRepositoryInterface $optionRepository,
        TextOptionRepositoryInterface $textOptionRepository
    ) {
        $this->command = $command;
        $this->optionRepository = $optionRepository;
        $this->textOptionRepository = $textOptionRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $textOption = new TextOption($this->command->getTextOptionId());
        $textOption->setName($this->command->getName());
        $textOption->setDescription($this->command->getDescription());
        $textOption->setSortOrder($this->command->getSortOrder());
        $textOption->setType($this->command->getTextOptionType());

        $this->textOptionRepository->create($textOption);
    }
}
