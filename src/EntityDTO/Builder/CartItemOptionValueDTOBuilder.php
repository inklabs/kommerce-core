<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\EntityDTO\CartItemOptionValueDTO;

class CartItemOptionValueDTOBuilder
{
    /** @var CartItemOptionValueDTO */
    protected $cartItemOptionValueDTO;

    public function __construct(CartItemOptionValue $cartItemOptionValue)
    {
        $this->cartItemOptionValue = $cartItemOptionValue;

        $this->cartItemOptionValueDTO = new CartItemOptionValueDTO;
        $this->cartItemOptionValueDTO->id      = $this->cartItemOptionValue->getId();
        $this->cartItemOptionValueDTO->created = $this->cartItemOptionValue->getCreated();
        $this->cartItemOptionValueDTO->updated = $this->cartItemOptionValue->getUpdated();

        $this->cartItemOptionValueDTO->optionValue = $this->cartItemOptionValue->getOptionValue()->getDTOBuilder()
            ->withAllData()
            ->build();
    }

    public function build()
    {
        return $this->cartItemOptionValueDTO;
    }
}
