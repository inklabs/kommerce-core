<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCartPriceRuleCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleId;

    public function __construct(string $cartPriceRuleId)
    {
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
    }

    public function getCartPriceRuleId(): UuidInterface
    {
        return $this->cartPriceRuleId;
    }
}
