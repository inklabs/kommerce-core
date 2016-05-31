<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityDTO\TextOptionDTO;

class TextOptionDTOBuilder
{
    /** @var TextOption */
    protected $textOption;

    /** @var TextOptionDTO */
    protected $textOptionDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(TextOption $textOption, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->textOption = $textOption;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->textOptionDTO = new TextOptionDTO;
        $this->textOptionDTO->id          = $this->textOption->getId();
        $this->textOptionDTO->name        = $this->textOption->getname();
        $this->textOptionDTO->description = $this->textOption->getDescription();
        $this->textOptionDTO->sortOrder   = $this->textOption->getSortOrder();
        $this->textOptionDTO->created     = $this->textOption->getCreated();
        $this->textOptionDTO->updated     = $this->textOption->getUpdated();

        $this->textOptionDTO->type = $this->dtoBuilderFactory
            ->getTextOptionTypeDTOBuilder($this->textOption->getType())
            ->build();
    }

    public function withTags()
    {
        foreach ($this->textOption->getTags() as $tag) {
            $this->textOptionDTO->tags[] = $this->dtoBuilderFactory
                ->getTagDTOBuilder($tag)
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTags();
    }

    public function build()
    {
        return $this->textOptionDTO;
    }
}
