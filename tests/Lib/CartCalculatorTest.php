<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CartCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTotal()
    {
        $product1 = new Entity\Product;
        $product1->setUnitPrice(500);
        $cartItem1 = new Entity\CartItem;
        $cartItem1->setProduct($product1);
        $cartItem1->setQuantity(2);

        $product2 = new Entity\Product;
        $product2->setUnitPrice(300);
        $cartItem2 = new Entity\CartItem;
        $cartItem2->setProduct($product2);
        $cartItem2->setQuantity(1);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1300;
        $expectedCartTotal->subtotal = 1300;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1300;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCartPriceRules()
    {
        $productShirt = new Entity\Product;
        $productShirt->setId(1);
        $productShirt->setUnitPrice(1200);

        $productPoster = new Entity\Product;
        $productPoster->setId(2);
        $productPoster->setUnitPrice(500);

        $cartPriceRule = new Entity\CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new Entity\CartPriceRuleDiscount($productPoster));

        $pricing = new Lib\Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new Entity\CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(1);

        $cartItem2 = new Entity\CartItem;
        $cartItem2->setProduct($productPoster);
        $cartItem2->setQuantity(1);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1700;
        $expectedCartTotal->subtotal = 1700;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1200;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->cartPriceRules = [$cartPriceRule];

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalCartPriceRuleInvalidCartItems()
    {
        $productShirt = new Entity\Product;
        $productShirt->setId(1);
        $productShirt->setUnitPrice(1200);

        $productPoster = new Entity\Product;
        $productPoster->setId(2);
        $productPoster->setUnitPrice(500);

        $productJacket = new Entity\Product;
        $productJacket->setId(3);
        $productJacket->setUnitPrice(2500);

        $cartPriceRule = new Entity\CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new Entity\CartPriceRuleDiscount($productPoster, 1));

        $pricing = new Lib\Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new Entity\CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(1);

        $cartItem2 = new Entity\CartItem;
        $cartItem2->setProduct($productJacket);
        $cartItem2->setQuantity(1);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 3700;
        $expectedCartTotal->subtotal = 3700;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 3700;
        $expectedCartTotal->savings = 0;
        $expectedCartTotal->cartPriceRules = [];

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCartPriceRulesAndReducesTaxSubtotal()
    {
        $productShirt = new Entity\Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);
        $productShirt->setIsTaxable(true);

        $productPoster = new Entity\Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);
        $productPoster->setIsTaxable(true);

        $cartPriceRule = new Entity\CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new Entity\CartPriceRuleDiscount($productPoster, 1));
        $cartPriceRule->setReducesTaxSubtotal(true);

        $pricing = new Lib\Pricing;
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartItem1 = new Entity\CartItem;
        $cartItem1->setProduct($productShirt);
        $cartItem1->setQuantity(1);

        $cartItem2 = new Entity\CartItem;
        $cartItem2->setProduct($productPoster);
        $cartItem2->setQuantity(1);

        $taxRate = new Entity\TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1700;
        $expectedCartTotal->subtotal = 1700;
        $expectedCartTotal->taxSubtotal = 1200;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 96;
        $expectedCartTotal->total = 1296;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->cartPriceRules = [$cartPriceRule];
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator($pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCoupon()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(500);

        $coupon = new Entity\Coupon;
        $coupon->setid(1);
        $coupon->setName('20% Off');
        $coupon->setType(Entity\AbstractPromotion::TYPE_PERCENT);
        $coupon->setValue(20);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(5);

        $cart = new Entity\Cart;
        $cart->addCoupon($coupon);
        $cart->addCartItem($cartItem);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 2500;
        $expectedCartTotal->subtotal = 2500;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2000;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->coupons = [$coupon];

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithCouponWithFreeShipping()
    {
        $coupon = new Entity\Coupon;
        $coupon->setid(1);
        $coupon->setName('20% Off');
        $coupon->setType(Entity\AbstractPromotion::TYPE_PERCENT);
        $coupon->setValue(20);
        $coupon->setFlagFreeShipping(true);

        $product = new Entity\Product;
        $product->setUnitPrice(500);

        $shippingRate = new Entity\ShippingRate;
        $shippingRate->setCode('4');
        $shippingRate->setName('Parcel Post');
        $shippingRate->setCost(1000);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Entity\Cart;
        $cart->addCoupon($coupon);
        $cart->addCartItem($cartItem);
        $cart->setShippingRate($shippingRate);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->shippingDiscount = 1000;
        $expectedCartTotal->discount = 1200;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 800;
        $expectedCartTotal->savings = 1200;
        $expectedCartTotal->coupons = [$coupon];

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithShipping()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(500);

        $shippingRate = new Entity\ShippingRate;
        $shippingRate->setCode('4');
        $shippingRate->setName('Parcel Post');
        $shippingRate->setCost(1000);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(3);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem);
        $cart->setShippingRate($shippingRate);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1500;
        $expectedCartTotal->subtotal = 1500;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2500;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxNotAppliedToShipping()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(500);
        $product->setIsTaxable(true);

        $taxRate = new Entity\TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->taxSubtotal = 1000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 80;
        $expectedCartTotal->total = 1080;
        $expectedCartTotal->savings = 0;
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxAppliedToShipping()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(500);
        $product->setIsTaxable(true);

        $taxRate = new Entity\TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(true);

        $shippingRate = new Entity\ShippingRate;
        $shippingRate->setCode('4');
        $shippingRate->setName('Parcel Post');
        $shippingRate->setCost(1000);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem);
        $cart->setShippingRate($shippingRate);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->taxSubtotal = 1000;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 160;
        $expectedCartTotal->total = 2160;
        $expectedCartTotal->savings = 0;
        $expectedCartTotal->taxRate = $taxRate;

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxAndProductNotTaxable()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(500);
        $product->setIsTaxable(false);

        $taxRate = new Entity\TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new Entity\CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1000;
        $expectedCartTotal->savings = 0;

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }

    public function testGetTotalWithZip5TaxAndCouponNoReduceSubtotal()
    {
        $product = new Entity\Product;
        $product->setUnitPrice(2000);
        $product->setIsTaxable(true);

        $taxRate = new Entity\TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $coupon = new Entity\Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setType(Entity\AbstractPromotion::TYPE_PERCENT);
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000);
        $coupon->setMaxOrderValue(10000);
        $coupon->setReducesTaxSubtotal(false);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        $cart = new Entity\Cart;
        $cart->addCoupon($coupon);
        $cart->addCartItem($cartItem);
        $cart->setTaxRate($taxRate);

        $expectedCartTotal = new Entity\CartTotal;
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

        $cartCalculator = new CartCalculator(new Lib\Pricing);
        $this->assertEquals($expectedCartTotal, $cartCalculator->getTotal($cart));
    }
}
