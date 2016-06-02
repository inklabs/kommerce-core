<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityDTO\TextOptionDTO;

class TextOptionDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var TextOption */
    protected $entity;

    /** @var TextOptionDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(TextOption $textOption, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $textOption;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new TextOptionDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->name        = $this->entity->getname();
        $this->entityDTO->description = $this->entity->getDescription();
        $this->entityDTO->sortOrder   = $this->entity->getSortOrder();

        $this->entityDTO->type = $this->dtoBuilderFactory
            ->getTextOptionTypeDTOBuilder($this->entity->getType())
            ->build();
    }

    public function withTags()
    {
        foreach ($this->entity->getTags() as $tag) {
            $this->entityDTO->tags[] = $this->dtoBuilderFactory
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
