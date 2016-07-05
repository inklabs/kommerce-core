<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\EntityDTO\CartItemOptionProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class CartItemOptionProductDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var CartItemOptionProduct */
    private $entity;

    /** @var CartItemOptionProductDTO  */
    private $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        CartItemOptionProduct $cartItemOptionProduct,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $cartItemOptionProduct;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new CartItemOptionProductDTO;
        $this->setId();
        $this->setTime();

        $this->entityDTO->optionProduct = $this->dtoBuilderFactory
            ->getOptionProductDTOBuilder($this->entity->getOptionProduct())
            ->build();
    }

    /**
     * @return static
     */
    public function withOptionProduct(PricingInterface $pricing)
    {
        $this->entityDTO->optionProduct = $this->dtoBuilderFactory
            ->getOptionProductDTOBuilder($this->entity->getOptionProduct())
            ->withOption()
            ->withProduct($pricing)
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData(PricingInterface $pricing)
    {
        return $this
            ->withOptionProduct($pricing);
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
