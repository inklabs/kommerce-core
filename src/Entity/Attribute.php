<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\EntityDTO\Builder\AttributeDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Attribute implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var int */
    protected $sortOrder;

    /** @var AttributeValue[] */
    protected $attributeValues;

    /** @var ProductAttribute[] */
    protected $productAttributes;

    public function __construct()
    {
        $this->setCreated();
        $this->attributeValues = new ArrayCollection;
        $this->productAttributes = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('sortOrder', new Assert\NotNull);
        $metadata->addPropertyConstraint('sortOrder', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function addAttributeValue(AttributeValue $attributeValue)
    {
        $attributeValue->setAttribute($this);
        $this->attributeValues[] = $attributeValue;
    }

    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttributes[] = $productAttribute;
    }

    public function getDTOBuilder()
    {
        return new AttributeDTOBuilder($this);
    }
}
