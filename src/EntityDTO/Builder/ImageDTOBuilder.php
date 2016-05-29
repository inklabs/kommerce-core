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

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Image $image, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->image = $image;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->initializeImageDTO();
        $this->imageDTO->id        = $this->image->getId();
        $this->imageDTO->path      = $this->image->getPath();
        $this->imageDTO->width     = $this->image->getWidth();
        $this->imageDTO->height    = $this->image->getHeight();
        $this->imageDTO->sortOrder = $this->image->getSortOrder();
        $this->imageDTO->created   = $this->image->getCreated();
        $this->imageDTO->updated   = $this->image->getUpdated();
    }

    protected function initializeImageDTO()
    {
        $this->imageDTO = new ImageDTO;
    }

    public function withProduct()
    {
        $product = $this->image->getProduct();
        if (! empty($product)) {
            $this->imageDTO->product = $this->dtoBuilderFactory->getProductDTOBuilder($product)
                ->build();
        }
        return $this;
    }

    public function withTag()
    {
        $tag = $this->image->getTag();
        if (! empty($tag)) {
            $this->imageDTO->tag = $this->dtoBuilderFactory->getTagDTOBuilder($tag)
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

    public function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->imageDTO;
    }
}
