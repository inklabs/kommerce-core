<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\EntityDTO\OptionProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class OptionProductDTOBuilder
{
    /** @var OptionProduct */
    protected $optionProduct;

    /** @var OptionProductDTO */
    protected $optionProductDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(OptionProduct $optionProduct, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->optionProduct = $optionProduct;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->optionProductDTO = new OptionProductDTO;
        $this->optionProductDTO->id             = $this->optionProduct->getId();
        $this->optionProductDTO->name           = $this->optionProduct->getname();
        $this->optionProductDTO->sku            = $this->optionProduct->getSku();
        $this->optionProductDTO->shippingWeight = $this->optionProduct->getShippingWeight();
        $this->optionProductDTO->sortOrder      = $this->optionProduct->getSortOrder();
        $this->optionProductDTO->created        = $this->optionProduct->getCreated();
        $this->optionProductDTO->updated        = $this->optionProduct->getUpdated();
    }

    public function withProduct(PricingInterface $pricing)
    {
        $this->optionProductDTO->product = $this->dtoBuilderFactory
            ->getProductDTOBuilder($this->optionProduct->getProduct())
            ->withPrice($pricing)
            ->build();

        return $this;
    }

    public function withOption()
    {
        $option = $this->optionProduct->getOption();
        if ($option !== null) {
            $this->optionProductDTO->option = $this->dtoBuilderFactory
                ->getOptionDTOBuilder($option)
                ->build();
        }

        return $this;
    }

    public function withAllData(PricingInterface $pricing)
    {
        return $this
            ->withOption()
            ->withProduct($pricing);
    }

    public function build()
    {
        return $this->optionProductDTO;
    }
}
