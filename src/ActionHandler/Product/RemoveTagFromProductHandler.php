<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveTagFromProductCommand;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class RemoveTagFromProductHandler implements CommandHandlerInterface
{
    /** @var RemoveTagFromProductCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        RemoveTagFromProductCommand $command,
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
        $product = $this->productRepository->findOneById($this->command->getProductId());
        $tag = $this->tagRepository->findOneById($this->command->getTagId());

        $product->removeTag($tag);

        $this->productRepository->update($product);
    }
}
