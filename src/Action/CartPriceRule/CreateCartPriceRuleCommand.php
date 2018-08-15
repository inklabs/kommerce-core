<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Uuid;

final class CreateCartPriceRuleCommand extends AbstractCartPriceRuleCommand
{
    public function __construct(
        string $name,
        ?int $maxRedemptions,
        bool $reducesTaxSubtotal,
        ?int $startAt,
        ?int $endAt
    ) {
        return parent::__construct(
            $name,
            $maxRedemptions,
            $reducesTaxSubtotal,
            $startAt,
            $endAt,
            Uuid::uuid4()
        );
    }
}
