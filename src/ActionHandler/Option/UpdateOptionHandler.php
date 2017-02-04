<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateOptionHandler implements CommandHandlerInterface
{
    /** @var UpdateOptionCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    public function __construct(
        UpdateOptionCommand $command,
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
        $optionDTO = $this->command->getOptionDTO();
        $option = $this->optionRepository->findOneById($optionDTO->id);
        OptionDTOBuilder::setFromDTO($option, $optionDTO);

        $this->optionRepository->update($option);
    }
}
