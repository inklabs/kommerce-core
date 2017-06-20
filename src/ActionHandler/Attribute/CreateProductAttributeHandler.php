<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateProductAttributeCommand;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateProductAttributeHandler implements CommandHandlerInterface
{
    /** @var CreateProductAttributeCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    /** @var ProductAttributeRepositoryInterface */
    protected $productAttributeRepository;

    public function __construct(
        CreateProductAttributeCommand $command,
        ProductRepositoryInterface $productRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->command = $command;
        $this->productRepository = $productRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = $this->productRepository->findOneById(
            $this->command->getProductId()
        );

        $attributeValue = $this->attributeValueRepository->findOneById(
            $this->command->getAttributeValueId()
        );

        $productAttribute = new ProductAttribute(
            $product,
            $attributeValue,
            $this->command->getProductAttributeId()
        );

        $this->productAttributeRepository->create($productAttribute);
    }
}
