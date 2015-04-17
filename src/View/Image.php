<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Image
{
    public $id;
    public $encodedId;
    public $path;
    public $width;
    public $height;
    public $sortOrder;
    public $product;
    public $tag;
    public $created;
    public $updated;

    public function __construct(Entity\Image $image)
    {
        $this->image = $image;

        $this->id        = $image->getId();
        $this->encodedId = Lib\BaseConvert::encode($image->getId());
        $this->path      = $image->getPath();
        $this->width     = $image->getWidth();
        $this->height    = $image->getHeight();
        $this->sortOrder = $image->getSortOrder();
        $this->created   = $image->getCreated();
        $this->updated   = $image->getUpdated();
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
            $this->product = $product->getView()
                ->export();
        }
        return $this;
    }

    public function withTag()
    {
        $tag = $this->image->getTag();
        if (! empty($tag)) {
            $this->tag = $tag->getView()
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
