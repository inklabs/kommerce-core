<?php
namespace inklabs\kommerce\ActionResponse\Cart;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;

class GetCartBySessionIdResponse
{
    /** @var CartDTOBuilder */
    private $cartDTOBuilder;

    public function setCartDTOBuilder(CartDTOBuilder $cartDTOBuilder)
    {
        $this->cartDTOBuilder = $cartDTOBuilder;
    }

    public function getCartDTO()
    {
        return $this->cartDTOBuilder
            ->build();
    }
}
