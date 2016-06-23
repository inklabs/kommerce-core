<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\Service\OptionServiceInterface;

final class CreateOptionHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(CreateOptionCommand $command)
    {
        $option = OptionDTOBuilder::createFromDTO($command->getOptionDTO());
        $this->optionService->create($option);
    }
}
