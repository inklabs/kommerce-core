<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartPriceRuleProductItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleProductId;

    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $productId;

    /** @var int */
    private $quantity;

    /**
     * @param string $cartPriceRuleId
     * @param string $productId
     * @param int $quantity
     */
    public function __construct($cartPriceRuleId, $productId, $quantity)
    {
        $this->cartPriceRuleProductId = Uuid::uuid4();
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->productId = Uuid::fromString($productId);
        $this->quantity = $quantity;
    }

    public function getCartPriceRuleProductId()
    {
        return $this->cartPriceRuleProductId;
    }

    public function getCartPriceRuleId()
    {
        return $this->cartPriceRuleId;
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
