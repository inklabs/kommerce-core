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

    /** @var string|null */
    protected $description;

    /** @var AttributeChoiceType */
    private $choiceType;

    /** @var int */
    protected $sortOrder;

    /** @var AttributeValue[] */
    protected $attributeValues;

    /** @var ProductAttribute[] */
    protected $productAttributes;

    /**
     * @param string $name
     * @param AttributeChoiceType $choiceType
     * @param int $sortOrder
     * @param null $id
     */
    public function __construct($name, AttributeChoiceType $choiceType, $sortOrder, $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->name = (string) $name;
        $this->choiceType = $choiceType;
        $this->sortOrder = (int) $sortOrder;
        $this->attributeValues = new ArrayCollection();
        $this->productAttributes = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
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

    public function setChoiceType(AttributeChoiceType $choiceType)
    {
        $this->choiceType = $choiceType;
    }

    public function getChoiceType(): AttributeChoiceType
    {
        return $this->choiceType;
    }

    public function setSortOrder(int $sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder(): int
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
