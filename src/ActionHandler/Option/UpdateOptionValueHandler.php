<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionValueCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionValueDTOBuilder;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateOptionValueHandler implements CommandHandlerInterface
{
    /** @var UpdateOptionValueCommand */
    private $command;

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    /** @var OptionValueRepositoryInterface */
    private $optionValueRepository;

    public function __construct(
        UpdateOptionValueCommand $command,
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
        $optionValueDTO = $this->command->getOptionValueDTO();
        $optionValue = $this->optionRepository->getOptionValueById($optionValueDTO->id);
        OptionValueDTOBuilder::setFromDTO($optionValue, $optionValueDTO);

        $this->optionValueRepository->update($optionValue);
    }
}
