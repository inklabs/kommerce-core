<?php
namespace inklabs\kommerce\Action\Cart\Query;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;

class GetCartByUserIdResponse implements GetCartByUserIdResponseInterface
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
