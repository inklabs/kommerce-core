<?php
namespace inklabs\kommerce\ActionResponse\Cart;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;
use inklabs\kommerce\Lib\CartCalculator;

class GetCartResponse
{
    /** @var CartDTOBuilder */
    private $cartDTOBuilder;

    /** @var CartCalculator */
    private $cartCalculator;

    public function __construct(CartCalculator $cartCalculator)
    {
        $this->cartCalculator = $cartCalculator;
    }

    public function setCartDTOBuilder(CartDTOBuilder $cartDTOBuilder)
    {
        $this->cartDTOBuilder = $cartDTOBuilder;
    }

    public function getCartDTO()
    {
        return $this->cartDTOBuilder
            ->build();
    }

    public function getCartDTOWithAllData()
    {
        return $this->cartDTOBuilder
            ->withAllData($this->cartCalculator)
            ->build();
    }
}
