<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
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
        $this->entityDTO->name           = $this->entity->getName();
        $this->entityDTO->sku            = $this->entity->getSku();
        $this->entityDTO->shippingWeight = $this->entity->getShippingWeight();
        $this->entityDTO->sortOrder      = $this->entity->getSortOrder();
    }

    public static function createFromDTO(Option $option, Product $product, OptionProductDTO $optionProductDTO)
    {
        $optionProduct = new OptionProduct($option, $product);
        self::setFromDTO($optionProduct, $optionProductDTO);
        return $optionProduct;
    }

    public static function setFromDTO(OptionProduct & $optionProduct, OptionProductDTO $optionProductDTO)
    {
        $optionProduct->setSortOrder($optionProductDTO->sortOrder);
    }

    /**
     * @param PricingInterface $pricing
     * @return static
     */
    public function withProduct(PricingInterface $pricing)
    {
        $this->entityDTO->product = $this->dtoBuilderFactory
            ->getProductDTOBuilder($this->entity->getProduct())
            ->withPrice($pricing)
            ->build();

        return $this;
    }

    /**
     * @return static
     */
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

    /**
     * @param PricingInterface $pricing
     * @return static
     */
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
        unset($this->entity);
        return $this->entityDTO;
    }
}
