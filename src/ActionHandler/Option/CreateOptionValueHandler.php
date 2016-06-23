<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionValueCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionValueDTOBuilder;
use inklabs\kommerce\Service\OptionServiceInterface;

final class CreateOptionValueHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(CreateOptionValueCommand $command)
    {
        $option = $this->optionService->findOneById(
            $command->getOptionId()
        );

        $optionValue = OptionValueDTOBuilder::createFromDTO(
            $option,
            $command->getOptionValueDTO()
        );
        $this->optionService->createOptionValue($optionValue);
    }
}
