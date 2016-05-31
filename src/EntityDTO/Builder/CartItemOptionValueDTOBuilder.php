<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\EntityDTO\CartItemOptionValueDTO;

class CartItemOptionValueDTOBuilder
{
    private $cartItemOptionValue;

    /** @var CartItemOptionValueDTO */
    private $cartItemOptionValueDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(CartItemOptionValue $cartItemOptionValue, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->cartItemOptionValue = $cartItemOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->cartItemOptionValueDTO = new CartItemOptionValueDTO;
        $this->cartItemOptionValueDTO->id      = $this->cartItemOptionValue->getId();
        $this->cartItemOptionValueDTO->created = $this->cartItemOptionValue->getCreated();
        $this->cartItemOptionValueDTO->updated = $this->cartItemOptionValue->getUpdated();

        $this->cartItemOptionValueDTO->optionValue = $this->dtoBuilderFactory
            ->getOptionValueDTOBuilder($this->cartItemOptionValue->getOptionValue())
            ->withAllData()
            ->build();
    }

    public function build()
    {
        return $this->cartItemOptionValueDTO;
    }
}
