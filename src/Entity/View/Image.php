<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Image
{
    private $image;

    public $id;
    public $path;
    public $width;
    public $height;
    public $sortOrder;
    public $product;
    public $tag;

    public function __construct(Entity\Image $image)
    {
        $this->image = $image;

        $this->id        = $image->getId();
        $this->path      = $image->getPath();
        $this->width     = $image->getWidth();
        $this->height    = $image->getHeight();
        $this->sortOrder = $image->getSortOrder();

        return $this;
    }

    public static function factory(Entity\Image $image)
    {
        return new static($image);
    }

    public function export()
    {
        unset($this->image);
        return $this;
    }

    public function withProduct()
    {
        $product = $this->image->getProduct();
        if (! empty($product)) {
            $this->product = $product
                ->getView()
                ->export();
        }
        return $this;
    }

    public function withTag()
    {
        $tag = $this->image->getTag();
        if (! empty($tag)) {
            $this->tag = $tag
                ->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct()
            ->withTag();
    }
}
