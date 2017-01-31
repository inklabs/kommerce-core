<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\CreateProductCommand;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateProductHandler implements CommandHandlerInterface
{
    /** @var CreateProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(CreateProductCommand $command, ProductRepositoryInterface $productRepository)
    {
        $this->command = $command;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = ProductDTOBuilder::createFromDTO(
            $this->command->getProductId(),
            $this->command->getProductDTO()
        );

        $this->productRepository->create($product);
    }
}
