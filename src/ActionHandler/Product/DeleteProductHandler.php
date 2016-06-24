<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\DeleteProductCommand;
use inklabs\kommerce\Service\ProductServiceInterface;

final class DeleteProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(DeleteProductCommand $command)
    {
        $product = $this->productService->findOneById($command->getProductId());
        $this->productService->delete($product);
    }
}
