<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionValueCommand;
use inklabs\kommerce\Service\OptionServiceInterface;

final class DeleteOptionValueHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(DeleteOptionValueCommand $command)
    {
        $optionValue = $this->optionService->getOptionValueById($command->getOptionValueId());
        $this->optionService->deleteOptionValue($optionValue);
    }
}
