<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UnsetDefaultImageForProductCommand;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UnsetDefaultImageForProductHandler implements CommandHandlerInterface
{
    /** @var UnsetDefaultImageForProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(
        UnsetDefaultImageForProductCommand $command,
        ProductRepositoryInterface $productRepository
    ) {
        $this->command = $command;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = $this->productRepository->findOneById($this->command->getProductId());
        $product->setDefaultImage(null);

        $this->productRepository->update($product);
    }
}
