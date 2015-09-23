<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Lib\BaseConvert;

class ImageDTOBuilder
{
    /** @var Image */
    protected $image;

    /** @var ImageDTO */
    protected $imageDTO;

    public function __construct(Image $image)
    {
        $this->image = $image;

        $this->imageDTO = new ImageDTO;
        $this->imageDTO->id        = $this->image->getId();
        $this->imageDTO->encodedId = BaseConvert::encode($this->image->getId());
        $this->imageDTO->path      = $this->image->getPath();
        $this->imageDTO->width     = $this->image->getWidth();
        $this->imageDTO->height    = $this->image->getHeight();
        $this->imageDTO->sortOrder = $this->image->getSortOrder();
        $this->imageDTO->created   = $this->image->getCreated();
        $this->imageDTO->updated   = $this->image->getUpdated();
    }

    public function withProduct()
    {
        $product = $this->image->getProduct();
        if (! empty($product)) {
            $this->imageDTO->product = $product->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withTag()
    {
        $tag = $this->image->getTag();
        if (! empty($tag)) {
            $this->imageDTO->tag = $tag->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct()
            ->withTag();
    }

    public function build()
    {
        return $this->imageDTO;
    }
}
