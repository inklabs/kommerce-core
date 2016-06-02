<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\EntityDTO\ProductAttributeDTO;

class ProductAttributeDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var ProductAttribute */
    protected $entity;

    /** @var ProductAttributeDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(ProductAttribute $productAttribute, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $productAttribute;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new ProductAttributeDTO;
        $this->setId();
        $this->setTime();
    }

    public function withProduct()
    {
        $product = $this->entity->getProduct();
        if ($product !== null) {
            $this->entityDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($product)
                ->build();
        }

        return $this;
    }

    public function withAttribute()
    {
        $this->entityDTO->attribute = $this->dtoBuilderFactory
            ->getAttributeDTOBuilder($this->entity->getAttribute())
            ->build();

        return $this;
    }

    public function withAttributeValue()
    {
        $this->entityDTO->attributeValue = $this->dtoBuilderFactory
            ->getAttributeValueDTOBuilder($this->entity->getAttributeValue())
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct()
            ->withAttribute()
            ->withAttributeValue();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
