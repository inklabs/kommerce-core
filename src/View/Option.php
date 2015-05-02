<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\Lib;

class Option
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

    /** @var Tag[] */
    public $tags = [];

    /** @var OptionProduct[] */
    public $optionProducts = [];

    /** @var OptionValue[] */
    public $optionValues = [];

    public $created;
    public $updated;

    public function __construct(Entity\Option $option)
    {
        $this->option = $option;

        $this->id          = $option->getId();
        $this->encodedId   = Lib\BaseConvert::encode($option->getId());
        $this->name        = $option->getname();
        $this->description = $option->getDescription();
        $this->sortOrder   = $option->getSortOrder();
        $this->type        = $option->getType();
        $this->created     = $option->getCreated();
        $this->updated     = $option->getUpdated();
    }

    public function export()
    {
        unset($this->option);
        return $this;
    }

    public function withOptionProducts(Lib\PricingInterface $pricing)
    {
        foreach ($this->option->getOptionProducts() as $optionProduct) {
            $this->optionProducts[] = $optionProduct->getView()
                ->withProduct($pricing)
                ->export();
        }

        return $this;
    }

    public function withOptionValues()
    {
        foreach ($this->option->getOptionValues() as $optionValue) {
            $this->optionValues[] = $optionValue->getView()
                ->withPrice()
                ->export();
        }

        return $this;
    }

    public function withTags()
    {
        foreach ($this->option->getTags() as $tag) {
            $this->tags[] = $tag->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData(Lib\PricingInterface $pricing)
    {
        return $this
            ->withTags()
            ->withOptionProducts($pricing)
            ->withOptionValues();
    }
}
