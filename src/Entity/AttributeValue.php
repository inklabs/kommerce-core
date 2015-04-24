<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class AttributeValue implements EntityInterface
{
    use Accessor\Time, Accessor\Id;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var Attribute */
    protected $attribute;

    /** @var int */
    protected $sortOrder;

    /** @var ProductAttribute[] */
    protected $productAttributes;

    public function __construct()
    {
        $this->setCreated();
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

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getSku()
    {
        return $this->sku;
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

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttributes[] = $productAttribute;
    }

    public function getView()
    {
        return new View\AttributeValue($this);
    }
}
