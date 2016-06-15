<?php
namespace inklabs\kommerce\Action\Cart\Query;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;

interface GetCartBySessionIdResponseInterface
{
    public function setCartDTOBuilder(CartDTOBuilder $cartDTOBuilder);
}
