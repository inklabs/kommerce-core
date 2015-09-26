<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\EntityDTO\CartItemTextOptionValueDTO;

class CartItemTextOptionValueDTOBuilder
{
    /** @var CartItemTextOptionValue */
    protected $cartItemTextOptionValue;

    /** @var CartItemTextOptionValueDTO */
    protected $cartItemTextOptionValueDTO;

    public function __construct(CartItemTextOptionValue $cartItemTextOptionValue)
    {
        $this->cartItemTextOptionValue = $cartItemTextOptionValue;

        $this->cartItemTextOptionValueDTO = new CartItemTextOptionValueDTO;
        $this->cartItemTextOptionValueDTO->id              = $this->cartItemTextOptionValue->getId();
        $this->cartItemTextOptionValueDTO->created         = $this->cartItemTextOptionValue->getCreated();
        $this->cartItemTextOptionValueDTO->updated         = $this->cartItemTextOptionValue->getUpdated();
        $this->cartItemTextOptionValueDTO->textOptionValue = $this->cartItemTextOptionValue->getTextOptionValue();
    }

    public function withTextOption()
    {
        $this->cartItemTextOptionValueDTO->textOption = $this->cartItemTextOptionValue->getTextOption()->getDTOBuilder()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
    }

    public function build()
    {
        return $this->cartItemTextOptionValueDTO;
    }
}
