<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateTextOptionCommand;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Service\OptionServiceInterface;

final class CreateTextOptionHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(CreateTextOptionCommand $command)
    {
        $textOption = new TextOption($command->getTextOptionId());
        $textOption->setName($command->getName());
        $textOption->setDescription($command->getDescription());
        $textOption->setSortOrder($command->getSortOrder());
        $textOption->setType($command->getTextOptionType());

        $this->optionService->createTextOption($textOption);
    }
}
