<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\Lib\PricingInterface;

class OptionDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Option */
    protected $entity;

    /** @var OptionDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Option $option, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $option;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->name        = $this->entity->getname();
        $this->entityDTO->description = $this->entity->getDescription();
        $this->entityDTO->sortOrder   = $this->entity->getSortOrder();

        $this->entityDTO->type = $this->dtoBuilderFactory
            ->getOptionTypeDTOBuilder($this->entity->getType())
            ->build();
    }

    protected function getEntityDTO()
    {
        return new OptionDTO;
    }

    public static function createFromDTO(OptionDTO $optionDTO)
    {
        $option = new Option;
        self::setFromDTO($option, $optionDTO);
        return $option;
    }

    private static function setFromDTO(Option & $option, OptionDTO $optionDTO)
    {
        $option->setName($optionDTO->name);
        $option->setDescription($optionDTO->description);
        $option->setSortOrder($optionDTO->sortOrder);
        $option->setType(OptionType::createById($optionDTO->type->id));
    }

    public function withOptionProducts(PricingInterface $pricing)
    {
        foreach ($this->entity->getOptionProducts() as $optionProduct) {
            $this->entityDTO->optionProducts[] = $this->dtoBuilderFactory
                ->getOptionProductDTOBuilder($optionProduct)
                ->withProduct($pricing)
                ->build();
        }

        return $this;
    }

    public function withOptionValues()
    {
        foreach ($this->entity->getOptionValues() as $optionValue) {
            $this->entityDTO->optionValues[] = $this->dtoBuilderFactory
                ->getOptionValueDTOBuilder($optionValue)
                ->withPrice()
                ->build();
        }

        return $this;
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

    public function withAllData(PricingInterface $pricing)
    {
        return $this
            ->withTags()
            ->withOptionProducts($pricing)
            ->withOptionValues();
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
