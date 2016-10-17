<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\SetDefaultImageForProductCommand;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class SetDefaultImageForProductHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    /** @var ImageServiceInterface */
    private $imageService;

    public function __construct(
        ProductServiceInterface $productService,
        ImageServiceInterface $imageService
    ) {
        $this->productService = $productService;
        $this->imageService = $imageService;
    }

    public function handle(SetDefaultImageForProductCommand $command)
    {
        $product = $this->productService->findOneById($command->getProductId());
        $image = $this->imageService->findOneById($command->getImageId());

        $product->setDefaultImage($image->getPath());

        $this->productService->update($product);
    }
}
