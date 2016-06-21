<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddCartItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $cartItemId;

    /** @var UuidInterface */
    private $cartId;

    /** @var UuidInterface */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var array|null */
    private $optionProductIds;

    /** @var array|null */
    private $optionValueIds;

    /** @var array|null */
    private $textOptionValues;

    /**
     * @param string $cartId
     * @param string $productId
     * @param int $quantity
     * @param array | null $optionProductIds
     * @param array | null $optionValuesIds
     * @param array | null $textOptionValues
     */
    public function __construct(
        $cartId,
        $productId,
        $quantity,
        array $optionProductIds = null,
        array $optionValuesIds = null,
        array $textOptionValues = null
    ) {
        $this->cartItemId = Uuid::uuid4();
        $this->cartId = Uuid::fromString($cartId);
        $this->productId = Uuid::fromString($productId);
        $this->quantity = (int) $quantity;
        $this->optionProductIds = $optionProductIds;
        $this->optionValueIds = $optionValuesIds;
        $this->textOptionValues = $textOptionValues;
    }

    public function getCartItemId()
    {
        return $this->cartItemId;
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

    public function getOptionProductIds()
    {
        return $this->optionProductIds;
    }

    public function getOptionValueIds()
    {
        return $this->optionValueIds;
    }

    public function getTextOptionValues()
    {
        return $this->textOptionValues;
    }
}
