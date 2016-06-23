<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionProductCommand;
use inklabs\kommerce\EntityDTO\Builder\OptionProductDTOBuilder;
use inklabs\kommerce\Service\OptionServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class CreateOptionProductHandler
{
    /** @var OptionServiceInterface */
    protected $optionService;

    /** @var ProductServiceInterface */
    private $productService;

    public function __construct(OptionServiceInterface $optionService, ProductServiceInterface $productService)
    {
        $this->optionService = $optionService;
        $this->productService = $productService;
    }

    public function handle(CreateOptionProductCommand $command)
    {
        $option = $this->optionService->findOneById(
            $command->getOptionId()
        );

        $product = $this->productService->findOneById(
            $command->getProductId()
        );

        $optionProduct = OptionProductDTOBuilder::createFromDTO(
            $option,
            $product,
            $command->getOptionProductDTO()
        );
        $this->optionService->createOptionProduct($optionProduct);
    }
}
