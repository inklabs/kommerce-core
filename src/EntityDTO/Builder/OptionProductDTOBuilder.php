<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\EntityDTO\OptionProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class OptionProductDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var OptionProduct */
    protected $entity;

    /** @var OptionProductDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(OptionProduct $optionProduct, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $optionProduct;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new OptionProductDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->name           = $this->entity->getname();
        $this->entityDTO->sku            = $this->entity->getSku();
        $this->entityDTO->shippingWeight = $this->entity->getShippingWeight();
        $this->entityDTO->sortOrder      = $this->entity->getSortOrder();
    }

    public function withProduct(PricingInterface $pricing)
    {
        $this->entityDTO->product = $this->dtoBuilderFactory
            ->getProductDTOBuilder($this->entity->getProduct())
            ->withPrice($pricing)
            ->build();

        return $this;
    }

    public function withOption()
    {
        $option = $this->entity->getOption();
        if ($option !== null) {
            $this->entityDTO->option = $this->dtoBuilderFactory
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
