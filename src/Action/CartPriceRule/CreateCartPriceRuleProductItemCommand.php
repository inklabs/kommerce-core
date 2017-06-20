<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartPriceRuleProductItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleProductItemId;

    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $productId;

    /** @var int */
    private $quantity;

    public function __construct(string $cartPriceRuleId, string $productId, int $quantity)
    {
        $this->cartPriceRuleProductItemId = Uuid::uuid4();
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->productId = Uuid::fromString($productId);
        $this->quantity = $quantity;
    }

    public function getCartPriceRuleProductItemId(): UuidInterface
    {
        return $this->cartPriceRuleProductItemId;
    }

    public function getCartPriceRuleId(): UuidInterface
    {
        return $this->cartPriceRuleId;
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
