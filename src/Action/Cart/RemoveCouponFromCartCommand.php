<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class RemoveCouponFromCartCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var UuidInterface */
    private $couponId;

    /**
     * @param string $cartId
     * @param string $couponId
     */
    public function __construct($cartId, $couponId)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->couponId = Uuid::fromString($couponId);
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getCouponId()
    {
        return $this->couponId;
    }
}
