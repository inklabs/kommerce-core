<?php
namespace inklabs\kommerce\View\OptionType;

use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Entity;

abstract class AbstractOptionType implements OptionTypeInterface
{
    /** @var int */
    public $id;

    /** @var string */
    public $encodedId;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var int */
    public $sortOrder;

    /** @var int */
    public $type;

    public $created;
    public $updated;

    /** @var View\Tag[] */
    public $tags;

    /** @var View\OptionValue\OptionValueInterface[] */
    public $optionValues;

    public function __construct(Entity\OptionType\AbstractOptionType $optionType)
    {
        $this->optionType = $optionType;

        $this->id          = $optionType->getId();
        $this->encodedId   = Lib\BaseConvert::encode($optionType->getId());
        $this->name        = $optionType->getname();
        $this->description = $optionType->getDescription();
        $this->sortOrder   = $optionType->getSortOrder();
        $this->type        = $optionType->getType();
        $this->created     = $optionType->getCreated();
        $this->updated     = $optionType->getUpdated();
    }

    public function export()
    {
        unset($this->optionType);
        return $this;
    }

    public function withOptionValues()
    {
        foreach ($this->optionType->getOptionValues() as $optionValue) {
            $this->optionValues[] = $optionValue->getView()
                ->export();
        }

        return $this;
    }

    public function withTags()
    {
        foreach ($this->optionType->getTags() as $tag) {
            $this->tags[] = $tag->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTags()
            ->withOptionValues();
    }
}
