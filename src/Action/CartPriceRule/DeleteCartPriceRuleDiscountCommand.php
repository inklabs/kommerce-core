<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCartPriceRuleDiscountCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleDiscountId;

    public function __construct(string $cartPriceRuleDiscountId)
    {
        $this->cartPriceRuleDiscountId = Uuid::fromString($cartPriceRuleDiscountId);
    }

    public function getCartPriceRuleDiscountId(): UuidInterface
    {
        return $this->cartPriceRuleDiscountId;
    }
}
