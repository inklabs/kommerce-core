<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Option implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var int */
    protected $type;
    const TYPE_SELECT   = 0;
    const TYPE_RADIO    = 1;
    const TYPE_CHECKBOX = 2;

    /** @var int */
    protected $sortOrder;

    /** @var ArrayCollection|Tag */
    protected $tags;

    /** @var OptionProduct[] */
    protected $optionProducts;

    /** @var OptionValue[] */
    protected $optionValues;

    public function __construct()
    {
        $this->setCreated();

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

        $metadata->addPropertyConstraint('type', new Assert\Choice([
            'choices' => array_keys(static::getTypeMapping()),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function getTypeMapping()
    {
        return [
            static::TYPE_SELECT => 'Select',
            static::TYPE_RADIO => 'Radio',
            static::TYPE_CHECKBOX => 'Checkbox',
        ];
    }

    /**
     * @return string
     */
    public function getTypeText()
    {
        return $this->getTypeMapping()[$this->getType()];
    }

    public function setType($type)
    {
        $this->type = (int) $type;
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

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addOptionProduct(OptionProduct $optionProduct)
    {
        $optionProduct->setOption($this);
        $this->optionProducts[] = $optionProduct;
    }

    public function getOptionProducts()
    {
        return $this->optionProducts;
    }

    public function addOptionValue(OptionValue $optionValue)
    {
        $optionValue->setOption($this);
        $this->optionValues[] = $optionValue;
    }

    public function getOptionValues()
    {
        return $this->optionValues;
    }

    public function getDTOBuilder()
    {
        return new OptionDTOBuilder($this);
    }
}
