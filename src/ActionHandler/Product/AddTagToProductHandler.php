<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\AddTagToProductCommand;
use inklabs\kommerce\Service\ProductServiceInterface;

final class AddTagToProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(AddTagToProductCommand $command)
    {
        $this->productService->addTag(
            $command->getProductId(),
            $command->getTagId()
        );
    }
}
