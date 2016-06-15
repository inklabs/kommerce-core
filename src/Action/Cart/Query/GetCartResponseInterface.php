<?php
namespace inklabs\kommerce\Action\Cart\Query;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;

interface GetCartResponseInterface
{
    public function setCartDTOBuilder(CartDTOBuilder $cartDTOBuilder);
}
