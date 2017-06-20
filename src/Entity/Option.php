<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Option implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string|null */
    protected $description;

    /** @var OptionType|null */
    protected $type;

    /** @var int */
    protected $sortOrder;

    /** @var Tag[]|ArrayCollection */
    protected $tags;

    /** @var OptionProduct[] */
    protected $optionProducts;

    /** @var OptionValue[] */
    protected $optionValues;

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();

        $this->setType(OptionType::select());
        $this->tags = new ArrayCollection;
        $this->optionProducts = new ArrayCollection;
        $this->optionValues = new ArrayCollection;
        $this->sortOrder = 0;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('sortOrder', new Assert\NotNull);
        $metadata->addPropertyConstraint('sortOrder', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Valid);
    }

    public function setType(OptionType $type)
    {
        $this->type = $type;
    }

    public function getType(): ?OptionType
    {
        return $this->type;
    }

    public function setName(string $name)
    {
        $this->name = (string) $name;
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

    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addOptionProduct(OptionProduct $optionProduct)
    {
        $this->optionProducts->add($optionProduct);
    }

    /**
     * @return OptionProduct[]
     */
    public function getOptionProducts()
    {
        return $this->optionProducts;
    }

    public function addOptionValue(OptionValue $optionValue)
    {
        $this->optionValues->add($optionValue);
    }

    /**
     * @return OptionValue[]
     */
    public function getOptionValues()
    {
        return $this->optionValues;
    }
}
