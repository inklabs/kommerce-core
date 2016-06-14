<?php
namespace inklabs\kommerce\Exception;

class DTOBuilderException extends Kommerce400Exception
{
    const INVALID_PAYMENT = 1;
    const INVALID_CART_PRICE_RULE_ITEM = 2;

    public static function invalidPayment()
    {
        return new self('Invalid payment', self::INVALID_PAYMENT);
    }

    public static function invalidCartPriceRuleItem()
    {
        return new self('Invalid CartPriceRuleItem', self::INVALID_CART_PRICE_RULE_ITEM);
    }
}
