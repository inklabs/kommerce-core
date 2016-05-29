<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Slug;

class TagDTOBuilder
{
    /** @var Tag */
    protected $tag;

    /** @var TagDTO */
    protected $tagDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Tag $tag, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->tag = $tag;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->initializeTagDTO();
        $this->tagDTO->id           = $this->tag->getId();
        $this->tagDTO->slug         = Slug::get($this->tag->getName());
        $this->tagDTO->name         = $this->tag->getName();
        $this->tagDTO->code         = $this->tag->getCode();
        $this->tagDTO->description  = $this->tag->getDescription();
        $this->tagDTO->defaultImage = $this->tag->getDefaultImage();
        $this->tagDTO->sortOrder    = $this->tag->getSortOrder();
        $this->tagDTO->isVisible    = $this->tag->isVisible();
        $this->tagDTO->isActive     = $this->tag->isActive();
        $this->tagDTO->created      = $this->tag->getCreated();
        $this->tagDTO->updated      = $this->tag->getUpdated();
    }

    protected function initializeTagDTO()
    {
        $this->tagDTO = new TagDTO();
    }

    public static function createFromDTO(TagDTO $tagDTO)
    {
        $tag = new Tag;
        self::setFromDTO($tag, $tagDTO);
        return $tag;
    }

    public static function setFromDTO(Tag & $tag, TagDTO $tagDTO)
    {
        $tag->setName($tagDTO->name);
        $tag->setCode($tagDTO->code);
        $tag->setDescription($tagDTO->description);
        $tag->setIsActive($tagDTO->isActive);
        $tag->setIsVisible($tagDTO->isVisible);
        $tag->setSortOrder($tagDTO->sortOrder);
    }

    public function withImages()
    {
        foreach ($this->tag->getImages() as $image) {
            $this->tagDTO->images[] = $this->dtoBuilderFactory->getImageDTOBuilder($image)
                ->build();
        }
        return $this;
    }

    public function withProducts(Pricing $pricing)
    {
        foreach ($this->tag->getProducts() as $product) {
            $this->tagDTO->products[] = $this->dtoBuilderFactory->getProductDTOBuilder($product)
                ->withAllData($pricing)
                ->build();
        }
        return $this;
    }

    public function withOptions(PricingInterface $pricing)
    {
        foreach ($this->tag->getOptions() as $option) {
            $this->tagDTO->options[] = $this->dtoBuilderFactory->getOptionDTOBuilder($option)
                ->withOptionProducts($pricing)
                ->withOptionValues()
                ->build();
        }
        return $this;
    }

    public function withTextOptions()
    {
        foreach ($this->tag->getTextOptions() as $textOption) {
            $this->tagDTO->textOptions[] = $this->dtoBuilderFactory->getTextOptionDTOBuilder($textOption)
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
        unset($this->tag);
        return $this->tagDTO;
    }
}
