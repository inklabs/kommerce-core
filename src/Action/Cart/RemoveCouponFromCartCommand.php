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

    public function __construct(string $cartId, string $couponId)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->couponId = Uuid::fromString($couponId);
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getCouponId(): UuidInterface
    {
        return $this->couponId;
    }
}
