<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartPriceRuleDiscountCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleDiscountId;

    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $productId;

    /** @var int */
    private $quantity;

    public function __construct(string $cartPriceRuleId, string $productId, int $quantity)
    {
        $this->cartPriceRuleDiscountId = Uuid::uuid4();
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->productId = Uuid::fromString($productId);
        $this->quantity = $quantity;
    }

    public function getCartPriceRuleDiscountId(): UuidInterface
    {
        return $this->cartPriceRuleDiscountId;
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
