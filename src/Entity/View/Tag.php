<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Tag
{
    public $id;
    public $encodedId;
    public $slug;
    public $name;
    public $description;
    public $defaultImage;
    public $isProductGroup;
    public $sortOrder;
    public $isVisible;
    public $products = [];
    public $images = [];

    public function __construct(Entity\Tag $tag)
    {
        $this->tag = $tag;

        $this->id             = $tag->getId();
        $this->encodedId      = Lib\BaseConvert::encode($tag->getId());
        $this->slug           = Lib\Slug::get($tag->getName());
        $this->name           = $tag->getName();
        $this->description    = $tag->getDescription();
        $this->defaultImage   = $tag->getDefaultImage();
        $this->isProductGroup = $tag->getIsProductGroup();
        $this->sortOrder      = $tag->getSortOrder();
        $this->isVisible      = $tag->getIsVisible();

        return $this;
    }

    public static function factory(Entity\Tag $tag)
    {
        return new static($tag);
    }

    public function export()
    {
        unset($this->tag);
        return $this;
    }

    public function withImages()
    {
        foreach ($this->tag->getImages() as $image) {
            $this->images[] = Image::factory($image)
                ->export();
        }
        return $this;
    }

    public function withProducts(\inklabs\kommerce\Service\Pricing $pricing)
    {
        foreach ($this->tag->getProducts() as $product) {
            $this->products[] = Product::factory($product)
                ->withAllData($pricing)
                ->export();
        }
        return $this;
    }

    public function withAllData(\inklabs\kommerce\Service\Pricing $pricing)
    {
        return $this
            ->withImages()
            ->withProducts($pricing);
    }
}
