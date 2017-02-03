<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionValueCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionValueDTOBuilder;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateOptionValueHandler implements CommandHandlerInterface
{
    /** @var CreateOptionValueCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var OptionValueRepositoryInterface */
    private $optionValueRepository;

    public function __construct(
        CreateOptionValueCommand $command,
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
        $option = $this->optionRepository->findOneById(
            $this->command->getOptionId()
        );

        $optionValue = OptionValueDTOBuilder::createFromDTO(
            $option,
            $this->command->getOptionValueDTO(),
            $this->command->getOptionValueId()
        );

        $this->optionValueRepository->create($optionValue);
    }
}
