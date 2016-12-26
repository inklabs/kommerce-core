<?php
namespace inklabs\kommerce\Action\CartPriceRule\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartPriceRuleRequest
{
    /** @var UuidInterface */
    private $cartPriceRuleId;

    /**
     * @param string $cartPriceRuleId
     */
    public function __construct($cartPriceRuleId)
    {
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
    }

    public function getCartPriceRuleId()
    {
        return $this->cartPriceRuleId;
    }
}
