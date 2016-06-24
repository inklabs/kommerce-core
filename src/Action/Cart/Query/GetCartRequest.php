<?php
namespace inklabs\kommerce\Action\Cart\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartRequest
{
    /** @var UuidInterface */
    private $cartId;

    /**
     * @param string $cartId
     */
    public function __construct($cartId)
    {
        $this->cartId = Uuid::fromString($cartId);
    }

    public function getCartId()
    {
        return $this->cartId;
    }
}
