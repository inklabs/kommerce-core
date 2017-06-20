<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\DeleteProductCommand;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteProductHandler implements CommandHandlerInterface
{
    /** @var DeleteProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(DeleteProductCommand $command, ProductRepositoryInterface $productRepository)
    {
        $this->command = $command;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = $this->productRepository->findOneById($this->command->getProductId());
        $this->productRepository->delete($product);
    }
}
