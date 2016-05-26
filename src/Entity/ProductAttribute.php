<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ProductAttributeDTOBuilder;
use Ramsey\Uuid\UuidInterface;

class ProductAttribute
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    protected $product_uuid;
    protected $attribute_uuid;
    protected $attributeValue_uuid;

    /** @var Product */
    protected $product;

    /** @var Attribute */
    protected $attribute;

    /** @var AttributeValue */
    protected $attributeValue;

    public function __construct(Product $product, Attribute $attribute, AttributeValue $attributeValue)
    {
        $this->setUuid();
        $this->setCreated();
        $this->product = $product;
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;

        $product->addProductAttribute($this);
        $attribute->addProductAttribute($this);
        $attributeValue->addProductAttribute($this);
        $this->product_uuid = $product->getUuid();
        $this->attribute_uuid = $attribute->getUuid();
        $this->attributeValue_uuid = $attributeValue->getUuid();
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    public function getDTOBuilder()
    {
        return new ProductAttributeDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setProductUuid(UuidInterface $uuid)
    {
        $this->product_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setAttributeUuid(UuidInterface $uuid)
    {
        $this->attribute_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setAttributeValueUuid(UuidInterface $uuid)
    {
        $this->attributeValue_uuid = $uuid;
    }
}
