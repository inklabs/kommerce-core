<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UpdateProductCommand;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateProductHandler implements CommandHandlerInterface
{
    /** @var UpdateProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(UpdateProductCommand $command, ProductRepositoryInterface $productRepository)
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
        $productDTO = $this->command->getProductDTO();
        $product = $this->productRepository->findOneById($productDTO->id);
        ProductDTOBuilder::setFromDTO($product, $productDTO);

        $this->productRepository->update($product);
    }
}
