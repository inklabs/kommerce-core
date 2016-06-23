<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionProductCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionProductDTOBuilder;
use inklabs\kommerce\Service\OptionServiceInterface;

final class UpdateOptionProductHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    public function handle(UpdateOptionProductCommand $command)
    {
        $optionProductDTO = $command->getOptionProductDTO();
        $optionProduct = $this->optionService->getOptionProductById($optionProductDTO->id);
        OptionProductDTOBuilder::setFromDTO($optionProduct, $optionProductDTO);

        $this->optionService->updateOptionProduct($optionProduct);
    }
}
