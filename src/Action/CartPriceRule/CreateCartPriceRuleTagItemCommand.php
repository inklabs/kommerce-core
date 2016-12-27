<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartPriceRuleTagItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleTagId;

    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $tagId;

    /** @var int */
    private $quantity;

    /**
     * @param string $cartPriceRuleId
     * @param string $tagId
     * @param int $quantity
     */
    public function __construct($cartPriceRuleId, $tagId, $quantity)
    {
        $this->cartPriceRuleTagId = Uuid::uuid4();
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->tagId = Uuid::fromString($tagId);
        $this->quantity = $quantity;
    }

    public function getCartPriceRuleTagId()
    {
        return $this->cartPriceRuleTagId;
    }

    public function getCartPriceRuleId()
    {
        return $this->cartPriceRuleId;
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
