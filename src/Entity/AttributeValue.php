<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class AttributeValue implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string|null */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var string|null */
    protected $description;

    /** @var int */
    protected $sortOrder;

    /** @var Attribute */
    protected $attribute;

    /** @var ProductAttribute[] */
    protected $productAttributes;

    /**
     * @param Attribute $attribute
     * @param string $name
     * @param int $sortOrder
     * @param UuidInterface $id
     */
    public function __construct(Attribute $attribute, $name, $sortOrder, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->setAttribute($attribute);
        $this->name = (string) $name;
        $this->sortOrder = (int) $sortOrder;
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

    public function setSku(string $sku)
    {
        $this->sku = $sku;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setSortOrder(int $sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function getAttribute(): Attribute
    {
        return $this->attribute;
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

    private function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
        $attribute->addAttributeValue($this);
    }
}
