<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddCartItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var UuidInterface */
    private $productId;

    /** @var int */
    private $quantity;

    /**
     * @param string $cartId
     * @param string $productId
     * @param int $quantity
     */
    public function __construct($cartId, $productId, $quantity)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->productId = Uuid::fromString($productId);
        $this->quantity = (int) $quantity;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
