<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service;

class Tag implements ViewInterface
{
    public $id;
    public $encodedId;
    public $slug;
    public $name;
    public $description;
    public $defaultImage;
    public $sortOrder;
    public $isVisible;
    public $isActive;
    public $created;
    public $updated;

    /** @var Product[] */
    public $products = [];

    /** @var Image[] */
    public $images = [];

    /** @var Option[] */
    public $options = [];

    /** @var TextOption[] */
    public $textOptions = [];

    public function __construct(Entity\Tag $tag)
    {
        $this->tag = $tag;

        $this->id             = $tag->getId();
        $this->encodedId      = Lib\BaseConvert::encode($tag->getId());
        $this->slug           = Lib\Slug::get($tag->getName());
        $this->name           = $tag->getName();
        $this->description    = $tag->getDescription();
        $this->defaultImage   = $tag->getDefaultImage();
        $this->sortOrder      = $tag->getSortOrder();
        $this->isVisible      = $tag->isVisible();
        $this->isActive       = $tag->isActive();
        $this->created        = $tag->getCreated();
        $this->updated        = $tag->getUpdated();
    }

    public function export()
    {
        unset($this->tag);
        return $this;
    }

    public function withImages()
    {
        foreach ($this->tag->getImages() as $image) {
            $this->images[] = $image->getView()
                ->export();
        }
        return $this;
    }

    public function withProducts(Lib\Pricing $pricing)
    {
        foreach ($this->tag->getProducts() as $product) {
            $this->products[] = $product->getView()
                ->withAllData($pricing)
                ->export();
        }
        return $this;
    }

    public function withOptions(Lib\Pricing $pricing)
    {
        foreach ($this->tag->getOptions() as $option) {
            $this->options[] = $option->getView()
                ->withOptionProducts($pricing)
                ->withOptionValues()
                ->export();
        }
        return $this;
    }

    public function withTextOptions()
    {
        foreach ($this->tag->getTextOptions() as $textOption) {
            $this->textOptions[] = $textOption->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData(Lib\Pricing $pricing)
    {
        return $this
            ->withImages()
            ->withProducts($pricing)
            ->withOptions($pricing)
            ->withTextOptions();
    }
}
