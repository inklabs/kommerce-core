<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ProductAttribute implements EntityInterface
{
    use TimeTrait, IdTrait;

    /** @var Product */
    protected $product;

    /**
     * @var Attribute
     * @deprecated
     */
    protected $attribute;

    /** @var AttributeValue */
    protected $attributeValue;

    public function __construct(Product $product, AttributeValue $attributeValue, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->product = $product;
        $this->attribute = $attributeValue->getAttribute();
        $this->attributeValue = $attributeValue;

        $product->addProductAttribute($this);
        $this->attribute->addProductAttribute($this);
        $attributeValue->addProductAttribute($this);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        // TODO: Implement loadValidatorMetadata() method.
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return Attribute
     * @deprecated
     */
    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function getAttributeValue(): AttributeValue
    {
        return $this->attributeValue;
    }
}
