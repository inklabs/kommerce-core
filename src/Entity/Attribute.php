<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Attribute implements IdEntityInterface
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
        $this->setId();
        $this->setCreated();
        $this->attributeValues = new ArrayCollection();
        $this->productAttributes = new ArrayCollection();
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

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = (int) $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function addAttributeValue(AttributeValue $attributeValue)
    {
        $this->attributeValues->add($attributeValue);
    }

    /**
     * @return AttributeValue[]
     */
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * @return ProductAttribute[]
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttributes->add($productAttribute);
    }
}
