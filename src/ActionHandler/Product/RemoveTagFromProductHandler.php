<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveTagFromProductCommand;
use inklabs\kommerce\Service\ProductServiceInterface;

final class RemoveTagFromProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(RemoveTagFromProductCommand $command)
    {
        $this->productService->addTag(
            $command->getProductId(),
            $command->getTagId()
        );
    }
}
