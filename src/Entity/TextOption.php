<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\TextOptionDTOBuilder;
use inklabs\kommerce\View;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class TextOption implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var int */
    protected $type;
    const TYPE_TEXT     = 3;
    const TYPE_TEXTAREA = 4;
    const TYPE_FILE     = 5;
    const TYPE_DATE     = 6;
    const TYPE_TIME     = 7;
    const TYPE_DATETIME = 8;

    /** @var int */
    protected $sortOrder;

    /** @var ArrayCollection|Tag */
    protected $tags;

    public function __construct()
    {
        $this->setCreated();

        $this->tags = new ArrayCollection;
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

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getView()
    {
        return new View\TextOption($this);
    }

    public function getDTOBuilder()
    {
        return new TextOptionDTOBuilder($this);
    }
}
