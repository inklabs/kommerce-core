<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCartPriceRuleItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleItemId;

    public function __construct(string $cartPriceRuleItemId)
    {
        $this->cartPriceRuleItemId = Uuid::fromString($cartPriceRuleItemId);
    }

    public function getCartPriceRuleItemId(): UuidInterface
    {
        return $this->cartPriceRuleItemId;
    }
}
