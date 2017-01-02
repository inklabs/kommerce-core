<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\CreateProductAttributeCommand;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

final class CreateProductAttributeHandler
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    /** @var ProductAttributeRepositoryInterface */
    protected $productAttributeRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function handle(CreateProductAttributeCommand $command)
    {
        $product = $this->productRepository->findOneById(
            $command->getProductId()
        );

        $attributeValue = $this->attributeValueRepository->findOneById(
            $command->getAttributeValueId()
        );

        $productAttribute = new ProductAttribute(
            $product,
            $attributeValue,
            $command->getProductAttributeId()
        );

        $this->productAttributeRepository->create($productAttribute);
    }
}
