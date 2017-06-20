<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartPriceRuleQuery implements QueryInterface
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
