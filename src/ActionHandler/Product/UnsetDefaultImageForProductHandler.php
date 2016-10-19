<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UnsetDefaultImageForProductCommand;
use inklabs\kommerce\Service\ProductServiceInterface;

final class UnsetDefaultImageForProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(UnsetDefaultImageForProductCommand $command)
    {
        $product = $this->productService->findOneById($command->getProductId());

        $product->setDefaultImage(null);

        $this->productService->update($product);
    }
}
