<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $cartId;

    public function __construct(string $cartId)
    {
        $this->cartId = Uuid::fromString($cartId);
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }
}
