<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Option
{
    public $id;
    public $name;
    public $type;
    public $description;
    public $sortOrder;
    public $created;
    public $updated;

    /* @var Product[] */
    public $products = [];

    /* @var Tag[] */
    public $tags = [];

    public function __construct(Entity\Option $option)
    {
        $this->option = $option;

        $this->id          = $option->getId();
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

    public function withProducts()
    {
        foreach ($this->option->getProducts() as $product) {
            $this->products[] = $product->getView()->export();
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

    public function withAllData()
    {
        return $this
            ->withProducts()
            ->withTags();
    }
}
