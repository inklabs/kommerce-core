<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionCommand;
use inklabs\kommerce\Service\OptionServiceInterface;

final class DeleteOptionHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(DeleteOptionCommand $command)
    {
        $option = $this->optionService->findOneById($command->getOptionId());
        $this->optionService->delete($option);
    }
}
