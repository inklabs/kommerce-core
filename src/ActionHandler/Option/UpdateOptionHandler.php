<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\Service\OptionServiceInterface;

final class UpdateOptionHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(UpdateOptionCommand $command)
    {
        $optionDTO = $command->getOptionDTO();
        $option = $this->optionService->findOneById($optionDTO->id);
        OptionDTOBuilder::setFromDTO($option, $optionDTO);

        $this->optionService->update($option);
    }
}
