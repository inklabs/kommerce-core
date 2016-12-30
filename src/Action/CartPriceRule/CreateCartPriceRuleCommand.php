<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Uuid;

final class CreateCartPriceRuleCommand extends AbstractCartPriceRuleCommand
{
    /**
     * @param string $name
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param int $startAt
     * @param int $endAt
     */
    public function __construct(
        $name,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startAt,
        $endAt
    ) {
        return parent::__construct(
            $name,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startAt,
            $endAt,
            Uuid::uuid4()
        );
    }
}
