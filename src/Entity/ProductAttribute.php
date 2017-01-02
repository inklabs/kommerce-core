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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        // TODO: Implement loadValidatorMetadata() method.
    }

    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return Attribute
     * @deprecated
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getAttributeValue()
    {
        return $this->attributeValue;
    }
}
