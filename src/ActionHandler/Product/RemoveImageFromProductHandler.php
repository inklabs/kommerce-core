<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveImageFromProductCommand;
use inklabs\kommerce\Service\ProductServiceInterface;

final class RemoveImageFromProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(RemoveImageFromProductCommand $command)
    {
        $this->productService->removeImage(
            $command->getProductId(),
            $command->getImageId()
        );
    }
}
