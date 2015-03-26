<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartPriceRuleDiscount = new CartPriceRuleDiscount(new Product);
        $cartPriceRuleDiscount->setQuantity(2);
        $cartPriceRuleDiscount->setCartPriceRule(new CartPriceRule);
        $cartPriceRuleDiscount->setProduct(new Product);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($cartPriceRuleDiscount));
        $this->assertSame(2, $cartPriceRuleDiscount->getQuantity());
        $this->assertTrue($cartPriceRuleDiscount->getProduct() instanceof Product);
        $this->assertTrue($cartPriceRuleDiscount->getCartPriceRule() instanceof CartPriceRule);
        $this->assertTrue($cartPriceRuleDiscount->getView() instanceof View\CartPriceRuleDiscount);
    }
}
