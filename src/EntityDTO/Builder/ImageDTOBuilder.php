<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;

class ImageDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Image */
    protected $entity;

    /** @var ImageDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Image $image, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $image;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new ImageDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->path      = $this->entity->getPath();
        $this->entityDTO->width     = $this->entity->getWidth();
        $this->entityDTO->height    = $this->entity->getHeight();
        $this->entityDTO->sortOrder = $this->entity->getSortOrder();
    }

    public function withProduct()
    {
        $product = $this->entity->getProduct();
        if (! empty($product)) {
            $this->entityDTO->product = $this->dtoBuilderFactory->getProductDTOBuilder($product)
                ->build();
        }
        return $this;
    }

    public function withTag()
    {
        $tag = $this->entity->getTag();
        if (! empty($tag)) {
            $this->entityDTO->tag = $this->dtoBuilderFactory->getTagDTOBuilder($tag)
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
