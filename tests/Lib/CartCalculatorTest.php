<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\TestCase\LibTestCase;

class CartCalculatorTest extends LibTestCase
{
    public function testGetTotal()
    {
        $product1 = new Product;
        $product1->setUnitPrice(500);
        $cartItem1 = new CartItem;
        $cartItem1->setProduct($product1);
        $cartItem1->setQuantity(2);

        $product2 = new Product;
        $product2->setUnitPrice(300);
        $cartItem2 = new CartItem;
        $cartItem2->setProduct($product2);
        $cartItem2->setQuantity(1);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1300;
        $expectedCartTotal->subtotal = 1300;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1300;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCartPriceRules()
    {
        $productShirt = new Product;
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setUnitPrice(500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster));

        $pricing = new Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(1);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($productPoster);
        $cartItem2->setQuantity(1);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1700;
        $expectedCartTotal->subtotal = 1700;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1200;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->addCartPriceRule($cartPriceRule);

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCartPriceRulesAppliedTwice()
    {
        $productShirt = new Product;
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setUnitPrice(500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster));

        $pricing = new Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(2);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($productPoster);
        $cartItem2->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 3400;
        $expectedCartTotal->subtotal = 3400;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 1000;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2400;
        $expectedCartTotal->savings = 1000;
        $expectedCartTotal->addCartPriceRule($cartPriceRule);

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCartPriceRulesAppliedOnlyTwice()
    {
        $productShirt = new Product;
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setUnitPrice(500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster));

        $pricing = new Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(3);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($productPoster);
        $cartItem2->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 4600;
        $expectedCartTotal->subtotal = 4600;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 1000;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 3600;
        $expectedCartTotal->savings = 1000;
        $expectedCartTotal->addCartPriceRule($cartPriceRule);

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalCartPriceRuleInvalidCartItems()
    {
        $productShirt = new Product;
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setUnitPrice(500);

        $productJacket = new Product;
        $productJacket->setUnitPrice(2500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

        $pricing = new Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(1);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($productJacket);
        $cartItem2->setQuantity(1);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 3700;
        $expectedCartTotal->subtotal = 3700;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 3700;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCartPriceRulesAndReducesTaxSubtotal()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);
        $productShirt->setIsTaxable(true);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);
        $productPoster->setIsTaxable(true);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));
        $cartPriceRule->setReducesTaxSubtotal(true);

        $pricing = new Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(1);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($productPoster);
        $cartItem2->setQuantity(1);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1700;
        $expectedCartTotal->subtotal = 1700;
        $expectedCartTotal->taxSubtotal = 1200;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 96;
        $expectedCartTotal->total = 1296;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->addCartPriceRule($cartPriceRule);
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCoupon()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $coupon = $this->dummyData->getCoupon();
        $coupon->setName('20% Off');
        $coupon->setType(PromotionType::percent());
        $coupon->setValue(20);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(5);

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addCartItem($cartItem);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 2500;
        $expectedCartTotal->subtotal = 2500;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2000;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->coupons = [$coupon];

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCouponWithFreeShipping()
    {
        $coupon = $this->dummyData->getCoupon();
        $coupon->setName('20% Off');
        $coupon->setType(PromotionType::percent());
        $coupon->setValue(20);
        $coupon->setFlagFreeShipping(true);

        $product = new Product;
        $product->setUnitPrice(500);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addCartItem($cartItem);
        $cart->setShipmentRate(new ShipmentRate(new Money(1000, 'USD')));

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->shippingDiscount = 1000;
        $expectedCartTotal->discount = 1200;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 800;
        $expectedCartTotal->savings = 1200;
        $expectedCartTotal->coupons = [$coupon];

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithShipping()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(3);

        $cart = new Cart;
        $cart->addCartItem($cartItem);
        $cart->setShipmentRate(new ShipmentRate(new Money(1000, 'USD')));

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1500;
        $expectedCartTotal->subtotal = 1500;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2500;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxNotAppliedToShipping()
    {
        $product = new Product;
        $product->setUnitPrice(500);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->taxSubtotal = 1000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 80;
        $expectedCartTotal->total = 1080;
        $expectedCartTotal->savings = 0;
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxAppliedToShipping()
    {
        $product = new Product;
        $product->setUnitPrice(500);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(true);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem);
        $cart->setShipmentRate(new ShipmentRate(new Money(1000, 'USD')));
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->taxSubtotal = 1000;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 160;
        $expectedCartTotal->total = 2160;
        $expectedCartTotal->savings = 0;
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxAndProductNotTaxable()
    {
        $product = new Product;
        $product->setUnitPrice(500);
        $product->setIsTaxable(false);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1000;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxAndCouponNoReduceSubtotal()
    {
        $product = new Product;
        $product->setUnitPrice(2000);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $coupon = $this->dummyData->getCoupon();
        $coupon->setName('20% Off orders under $100');
        $coupon->setType(PromotionType::percent());
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000);
        $coupon->setMaxOrderValue(10000);
        $coupon->setReducesTaxSubtotal(false);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addCartItem($cartItem);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 2000;
        $expectedCartTotal->subtotal = 2000;
        $expectedCartTotal->taxSubtotal = 2000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 400;
        $expectedCartTotal->tax = 160;
        $expectedCartTotal->total = 1760;
        $expectedCartTotal->savings = 400;
        $expectedCartTotal->coupons = [$coupon];
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }
}
