<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UpdateProductCommand;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\Service\ProductServiceInterface;

final class UpdateProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(UpdateProductCommand $command)
    {
        $productDTO = $command->getProductDTO();
        $product = $this->productService->findOneById($productDTO->id);
        ProductDTOBuilder::setFromDTO($product, $productDTO);

        $this->productService->update($product);
    }
}
