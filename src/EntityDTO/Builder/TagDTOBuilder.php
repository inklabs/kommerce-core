<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Slug;
use inklabs\kommerce\Lib\UuidInterface;

class TagDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Tag */
    protected $entity;

    /** @var TagDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Tag $tag, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $tag;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->slug         = Slug::get($this->entity->getName());
        $this->entityDTO->name         = $this->entity->getName();
        $this->entityDTO->code         = $this->entity->getCode();
        $this->entityDTO->description  = $this->entity->getDescription();
        $this->entityDTO->defaultImage = $this->entity->getDefaultImage();
        $this->entityDTO->sortOrder    = $this->entity->getSortOrder();
        $this->entityDTO->isVisible    = $this->entity->isVisible();
        $this->entityDTO->isActive     = $this->entity->isActive();
    }

    protected function getEntityDTO()
    {
        return new TagDTO();
    }

    public static function createFromDTO(UuidInterface $tagId, TagDTO $tagDTO)
    {
        $tag = new Tag($tagId);
        self::setFromDTO($tag, $tagDTO);
        return $tag;
    }

    public static function setFromDTO(Tag & $tag, TagDTO $tagDTO)
    {
        $tag->setName($tagDTO->name);
        $tag->setDefaultImage($tagDTO->defaultImage);
        $tag->setCode($tagDTO->code);
        $tag->setDescription($tagDTO->description);
        $tag->setIsActive($tagDTO->isActive);
        $tag->setIsVisible($tagDTO->isVisible);
        $tag->setSortOrder($tagDTO->sortOrder);
    }

    public function withImages()
    {
        foreach ($this->entity->getImages() as $image) {
            $this->entityDTO->images[] = $this->dtoBuilderFactory->getImageDTOBuilder($image)
                ->build();
        }
        return $this;
    }

    public function withProducts(Pricing $pricing)
    {
        foreach ($this->entity->getProducts() as $product) {
            $this->entityDTO->products[] = $this->dtoBuilderFactory->getProductDTOBuilder($product)
                ->withAllData($pricing)
                ->build();
        }
        return $this;
    }

    public function withOptions(PricingInterface $pricing)
    {
        foreach ($this->entity->getOptions() as $option) {
            $this->entityDTO->options[] = $this->dtoBuilderFactory->getOptionDTOBuilder($option)
                ->withOptionProducts($pricing)
                ->withOptionValues()
                ->build();
        }
        return $this;
    }

    public function withTextOptions()
    {
        foreach ($this->entity->getTextOptions() as $textOption) {
            $this->entityDTO->textOptions[] = $this->dtoBuilderFactory->getTextOptionDTOBuilder($textOption)
                ->build();
        }
        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withImages()
            ->withProducts($pricing)
            ->withOptions($pricing)
            ->withTextOptions();
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
