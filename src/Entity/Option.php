<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Option implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var OptionType */
    protected $type;

    /** @var int */
    protected $sortOrder;

    /** @var Tag[] | ArrayCollection */
    protected $tags;

    /** @var OptionProduct[] */
    protected $optionProducts;

    /** @var OptionValue[] */
    protected $optionValues;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();

        $this->setType(OptionType::select());
        $this->tags = new ArrayCollection;
        $this->optionProducts = new ArrayCollection;
        $this->optionValues = new ArrayCollection;
        $this->sortOrder = 0;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
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

    public function getType()
    {
        return $this->type;
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

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
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

    public function getDTOBuilder()
    {
        return new OptionDTOBuilder($this);
    }
}
