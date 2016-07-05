<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\EntityDTO\AttributeValueDTO;

class AttributeValueDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var AttributeValue */
    protected $entity;

    /** @var AttributeValueDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(AttributeValue $attributeValue, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $attributeValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new AttributeValueDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->sku         = $this->entity->getSku();
        $this->entityDTO->name        = $this->entity->getName();
        $this->entityDTO->description = $this->entity->getDescription();
        $this->entityDTO->sortOrder   = $this->entity->getSortOrder();
    }

    /**
     * @return static
     */
    public function withAttribute()
    {
        if ($this->entity->getAttribute() !== null) {
            $this->entityDTO->attribute = $this->dtoBuilderFactory
                ->getAttributeDTOBuilder($this->entity->getAttribute())
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withProductAttributes()
    {
        foreach ($this->entity->getProductAttributes() as $productAttribute) {
            $this->entityDTO->productAttributes[] = $this->dtoBuilderFactory
                ->getProductAttributeDTOBuilder($productAttribute)
                ->withProduct()
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this
            ->withAttribute()
            ->withProductAttributes();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
