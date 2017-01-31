<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\AddTagToProductCommand;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class AddTagToProductHandler implements CommandHandlerInterface
{
    /** @var AddTagToProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        AddTagToProductCommand $command,
        ProductRepositoryInterface $productRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->command = $command;
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $tag = $this->tagRepository->findOneById($this->command->getTagId());
        $product = $this->productRepository->findOneById($this->command->getProductId());
        $product->addTag($tag);

        $this->productRepository->update($product);
    }
}
