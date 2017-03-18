<?php
namespace inklabs\kommerce\ActionResponse\Cart;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCartBySessionIdResponse implements ResponseInterface
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
