<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionProductCommand;
use inklabs\kommerce\Service\OptionServiceInterface;

final class DeleteOptionProductHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(DeleteOptionProductCommand $command)
    {
        $optionProduct = $this->optionService->getOptionProductById($command->getOptionProductId());
        $this->optionService->deleteOptionProduct($optionProduct);
    }
}
