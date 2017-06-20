<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddCouponToCartCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var string */
    private $couponCode;

    public function __construct(string $cartId, string $couponCode)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->couponCode = $couponCode;
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}
