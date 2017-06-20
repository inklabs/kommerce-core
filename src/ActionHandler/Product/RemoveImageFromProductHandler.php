<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveImageFromProductCommand;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class RemoveImageFromProductHandler implements CommandHandlerInterface
{
    /** @var RemoveImageFromProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    public function __construct(
        RemoveImageFromProductCommand $command,
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
        $product = $this->productRepository->findOneById($this->command->getProductId());
        $image = $this->imageRepository->findOneById($this->command->getImageId());

        $product->removeImage($image);

        $this->productRepository->update($product);

        if ($image->getTag() === null) {
            $this->imageRepository->delete($image);
        }
    }
}
