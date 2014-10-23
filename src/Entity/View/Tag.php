<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Tag
{
    private $tag;

    public $id;
    public $name;
    public $description;
    public $defaultImage;
    public $isProductGroup;
    public $sortOrder;
    public $isVisible;
    public $products = [];

    public function __construct(Entity\Tag $tag)
    {
        $this->tag = $tag;

        $this->id             = $tag->getId();
        $this->name           = $tag->getName();
        $this->description    = $tag->getDescription();
        $this->defaultImage   = $tag->getDefaultImage();
        $this->isProductGroup = $tag->getIsProductGroup();
        $this->sortOrder      = $tag->getSortOrder();
        $this->isVisible      = $tag->getIsVisible();

        return $this;
    }

    public function export()
    {
        unset($this->tag);
        return $this;
    }

    public function withAllData()
    {
        foreach ($this->tag->getProducts() as $product) {
            $this->products[] = $product
                ->getView()
                ->withAllData()
                ->export();
        }
        return $this;
    }
}
