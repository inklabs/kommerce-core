<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartPriceRuleTagItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleTagItemId;

    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $tagId;

    /** @var int */
    private $quantity;

    public function __construct(string $cartPriceRuleId, string $tagId, int $quantity)
    {
        $this->cartPriceRuleTagItemId = Uuid::uuid4();
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->tagId = Uuid::fromString($tagId);
        $this->quantity = $quantity;
    }

    public function getCartPriceRuleTagItemId(): UuidInterface
    {
        return $this->cartPriceRuleTagItemId;
    }

    public function getCartPriceRuleId(): UuidInterface
    {
        return $this->cartPriceRuleId;
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
