<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class Option
{
    public $id;
    public $encodedId;
    public $name;
    public $type;
    public $description;
    public $sortOrder;
    public $created;
    public $updated;

    /** @var OptionValue[] */
    public $optionValues = [];

    /** @var Tag[] */
    public $tags = [];

    public function __construct(Entity\Option $option)
    {
        $this->option = $option;

        $this->id          = $option->getId();
        $this->encodedId   = Lib\BaseConvert::encode($option->getId());
        $this->name        = $option->getName();
        $this->type        = $option->getType();
        $this->description = $option->getDescription();
        $this->sortOrder   = $option->getSortOrder();
        $this->created     = $option->getCreated();
        $this->updated     = $option->getUpdated();
    }

    public function export()
    {
        unset($this->option);
        return $this;
    }

    public function withOptionValues(Pricing $pricing)
    {
        foreach ($this->option->getOptionValues() as $optionValue) {
            $this->optionValues[] = $optionValue->getView()
                ->withAllData($pricing)
                ->export();
        }
        return $this;
    }

    public function withTags()
    {
        foreach ($this->option->getTags() as $tag) {
            $this->tags[] = $tag->getView()->export();
        }
        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withOptionValues($pricing)
            ->withTags();
    }
}
