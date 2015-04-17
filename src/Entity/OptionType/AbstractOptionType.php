<?php
namespace inklabs\kommerce\Entity\OptionType;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Entity\OptionValue\OptionValueInterface;
use inklabs\kommerce\Entity;

abstract class AbstractOptionType implements OptionTypeInterface
{
    use Entity\Accessor\Time, Entity\Accessor\Id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var int */
    protected $sortOrder;

    /** @var int */
    protected $type;
    const TYPE_SELECT   = 0;
    const TYPE_RADIO    = 1;
    const TYPE_CHECKBOX = 2;
    const TYPE_TEXT     = 3;
    const TYPE_TEXTAREA = 4;
    const TYPE_FILE     = 5;
    const TYPE_DATE     = 6;
    const TYPE_TIME     = 7;
    const TYPE_DATETIME = 8;

    /** @var ArrayCollection|Entity\Tag */
    protected $tags;

    /** @var OptionValueInterface[] */
    protected $optionValues;

    public function __construct()
    {
        $this->setCreated();

        $this->tags = new ArrayCollection;
        $this->optionValues = new ArrayCollection;
        $this->sortOrder = 0;
    }

    abstract public function getView();

    public function getTypeMapping()
    {
        return [
            static::TYPE_SELECT => 'Select',
            static::TYPE_RADIO => 'Radio',
            static::TYPE_CHECKBOX => 'Checkbox',
            static::TYPE_TEXT => 'Text',
            static::TYPE_TEXTAREA => 'Textarea',
            static::TYPE_FILE => 'File',
            static::TYPE_DATE => 'Date',
            static::TYPE_TIME => 'Time',
            static::TYPE_DATETIME => 'Datetime',
        ];
    }

    /**
     * @return string
     */
    public function getTypeText()
    {
        return $this->getTypeMapping()[$this->type];
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
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = (int) $type;
    }

    public function getType()
    {
        return $this->type;
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

    public function addTag(Entity\Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addOptionValue(OptionValueInterface $optionValue)
    {
        $optionValue->setOptionType($this);
        $this->optionValues[] = $optionValue;
    }

    public function getOptionValues()
    {
        return $this->optionValues;
    }
}
