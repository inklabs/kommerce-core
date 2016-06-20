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

    /**
     * @param string $cartId
     * @param string $couponCode
     */
    public function __construct($cartId, $couponCode)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->couponCode = (string) $couponCode;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getCouponCode()
    {
        return $this->couponCode;
    }
}
