<?php
namespace inklabs\kommerce\Action\Cart\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartRequest
{
    /** @var UuidInterface */
    private $cartId;

    /**
     * @param string $cartIdString
     */
    public function __construct($cartIdString)
    {
        $this->cartId = Uuid::fromString($cartIdString);
    }

    public function getCartId()
    {
        return $this->cartId;
    }
}
