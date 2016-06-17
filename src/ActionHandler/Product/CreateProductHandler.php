<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\CreateProductCommand;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\Service\ProductServiceInterface;

final class CreateProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(CreateProductCommand $command)
    {
        $product = ProductDTOBuilder::createFromDTO($command->getProductDTO());
        $this->productService->create($product);
    }
}
