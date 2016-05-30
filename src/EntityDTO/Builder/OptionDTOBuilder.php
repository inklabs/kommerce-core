<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\Lib\PricingInterface;

class OptionDTOBuilder
{
    /** @var OptionDTO */
    protected $optionDTO;

    public function __construct(Option $option)
    {
        $this->option = $option;

        $this->optionDTO = new OptionDTO;
        $this->optionDTO->id          = $this->option->getId();
        $this->optionDTO->name        = $this->option->getname();
        $this->optionDTO->description = $this->option->getDescription();
        $this->optionDTO->sortOrder   = $this->option->getSortOrder();
        $this->optionDTO->created     = $this->option->getCreated();
        $this->optionDTO->updated     = $this->option->getUpdated();

        $this->optionDTO->type = $this->option->getType()->getDTOBuilder()
            ->build();
    }

    public function withOptionProducts(PricingInterface $pricing)
    {
        foreach ($this->option->getOptionProducts() as $optionProduct) {
            $this->optionDTO->optionProducts[] = $optionProduct->getDTOBuilder()
                ->withProduct($pricing)
                ->build();
        }

        return $this;
    }

    public function withOptionValues()
    {
        foreach ($this->option->getOptionValues() as $optionValue) {
            $this->optionDTO->optionValues[] = $optionValue->getDTOBuilder()
                ->withPrice()
                ->build();
        }

        return $this;
    }

    public function withTags()
    {
        foreach ($this->option->getTags() as $tag) {
            $this->optionDTO->tags[] = $tag->getDTOBuilder()
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
