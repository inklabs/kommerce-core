<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\SetDefaultImageForProductCommand;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class SetDefaultImageForProductHandler implements CommandHandlerInterface
{
    /** @var SetDefaultImageForProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    public function __construct(
        SetDefaultImageForProductCommand $command,
        ProductRepositoryInterface $productRepository,
        ImageRepositoryInterface $imageRepository
    ) {
        $this->command = $command;
        $this->productRepository = $productRepository;
        $this->imageRepository = $imageRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $image = $this->imageRepository->findOneById($this->command->getImageId());
        $product = $this->productRepository->findOneById($this->command->getProductId());
        $product->setDefaultImage($image->getPath());

        $this->productRepository->update($product);
    }
}
