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

    public function __construct(TextOption $textOption)
    {
        $this->textOption = $textOption;

        $this->textOptionDTO = new TextOptionDTO;
        $this->textOptionDTO->id          = $this->textOption->getId();
        $this->textOptionDTO->name        = $this->textOption->getname();
        $this->textOptionDTO->description = $this->textOption->getDescription();
        $this->textOptionDTO->sortOrder   = $this->textOption->getSortOrder();
        $this->textOptionDTO->created     = $this->textOption->getCreated();
        $this->textOptionDTO->updated     = $this->textOption->getUpdated();

        $this->textOptionDTO->type = $this->textOption->getType()->getDTOBuilder()
            ->build();
    }

    public function withTags()
    {
        foreach ($this->textOption->getTags() as $tag) {
            $this->textOptionDTO->tags[] = $tag->getDTOBuilder()
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
