<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionValueCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionValueDTOBuilder;
use inklabs\kommerce\Service\OptionServiceInterface;

final class UpdateOptionValueHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(UpdateOptionValueCommand $command)
    {
        $optionValueDTO = $command->getOptionValueDTO();
        $optionValue = $this->optionService->getOptionValueById($optionValueDTO->id);
        OptionValueDTOBuilder::setFromDTO($optionValue, $optionValueDTO);

        $this->optionService->updateOptionValue($optionValue);
    }
}
