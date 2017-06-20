<?php
namespace inklabs\kommerce\ActionResponse\Cart;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCartByUserIdResponse implements ResponseInterface
{
    /** @var CartDTOBuilder */
    private $cartDTOBuilder;

    public function setCartDTOBuilder(CartDTOBuilder $cartDTOBuilder): void
    {
        $this->cartDTOBuilder = $cartDTOBuilder;
    }

    public function getCartDTO(): CartDTO
    {
        return $this->cartDTOBuilder
            ->build();
    }
}
