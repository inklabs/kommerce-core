<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Option
{
    use Accessor\Time, Accessor\Id;

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

    /** @var OptionValue[] */
    protected $optionValues;

    /** @var ArrayCollection|Tag */
    protected $tags;

    public function __construct()
    {
        $this->setCreated();
        $this->optionValues = new ArrayCollection;
        $this->tags = new ArrayCollection;

        $this->sortOrder = 0;
    }

    public static function getTypeMapping()
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

    public function getTypeText()
    {
        return $this->getTypeMapping()[$this->type];
    }

    public function setName($name)
    {
        $this->name = $name;
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

    public function addOptionValue(OptionValue $optionValue)
    {
        $this->optionValues[] = $optionValue;
    }

    public function getOptionValues()
    {
        return $this->optionValues;
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getView()
    {
        return new View\Option($this);
    }
}
