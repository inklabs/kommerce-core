<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\Lib\PricingInterface;

class OptionDTOBuilder
{
    /** @var OptionDTO */
    protected $optionDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Option $option, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->option = $option;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->optionDTO = new OptionDTO;
        $this->optionDTO->id          = $this->option->getId();
        $this->optionDTO->name        = $this->option->getname();
        $this->optionDTO->description = $this->option->getDescription();
        $this->optionDTO->sortOrder   = $this->option->getSortOrder();
        $this->optionDTO->created     = $this->option->getCreated();
        $this->optionDTO->updated     = $this->option->getUpdated();

        $this->optionDTO->type = $this->dtoBuilderFactory
            ->getOptionTypeDTOBuilder($this->option->getType())
            ->build();
    }

    public function withOptionProducts(PricingInterface $pricing)
    {
        foreach ($this->option->getOptionProducts() as $optionProduct) {
            $this->optionDTO->optionProducts[] = $this->dtoBuilderFactory
                ->getOptionProductDTOBuilder($optionProduct)
                ->withProduct($pricing)
                ->build();
        }

        return $this;
    }

    public function withOptionValues()
    {
        foreach ($this->option->getOptionValues() as $optionValue) {
            $this->optionDTO->optionValues[] = $this->dtoBuilderFactory
                ->getOptionValueDTOBuilder($optionValue)
                ->withPrice()
                ->build();
        }

        return $this;
    }

    public function withTags()
    {
        foreach ($this->option->getTags() as $tag) {
            $this->optionDTO->tags[] = $this->dtoBuilderFactory
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

    public function build()
    {
        return $this->optionDTO;
    }
}
