<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\EntityDTO\CartItemDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;

class CartItemDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var CartItem */
    private $entity;

    /** @var CartItemDTO */
    private $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(CartItem $cartItem, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $cartItem;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new CartItemDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->fullSku        = $this->entity->getFullSku();
        $this->entityDTO->quantity       = $this->entity->getQuantity();
        $this->entityDTO->shippingWeight = $this->entity->getShippingWeight();
    }

    /**
     * @return static
     */
    public function withPrice(PricingInterface $pricing)
    {
        $this->entityDTO->price = $this->dtoBuilderFactory
            ->getPriceDTOBuilder($this->entity->getPrice($pricing))
            ->withAllData()
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withProduct(Pricing $pricing)
    {
        $this->entityDTO->product = $this->dtoBuilderFactory
            ->getProductDTOBuilder($this->entity->getProduct())
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withCartItemOptionProducts(PricingInterface $pricing)
    {
        foreach ($this->entity->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $this->entityDTO->cartItemOptionProducts[] = $this->dtoBuilderFactory
                ->getCartItemOptionProductDTOBuilder($cartItemOptionProduct)
                ->withOptionProduct($pricing)
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withCartItemOptionValues()
    {
        foreach ($this->entity->getCartItemOptionValues() as $cartItemOptionValue) {
            $this->entityDTO->cartItemOptionValues[] = $this->dtoBuilderFactory
                ->getCartItemOptionValueDTOBuilder($cartItemOptionValue)
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withCartItemTextOptionValues()
    {
        foreach ($this->entity->getCartItemTextOptionValues() as $cartItemTextOptionValue) {
            $this->entityDTO->cartItemTextOptionValues[] = $this->dtoBuilderFactory
                ->getCartItemTextOptionValueDTOBuilder($cartItemTextOptionValue)
                ->withTextOption()
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing)
            ->withCartItemOptionProducts($pricing)
            ->withCartItemOptionValues()
            ->withCartItemTextOptionValues();
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
