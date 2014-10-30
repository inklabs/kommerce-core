<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

class CartTest extends \PHPUnit_Framework_TestCase
{
    public function testAddItem()
    {
        $product = new Product;
        $product2 = new Product;

        $cart = new Cart;
        $cart->addItem($product, 5);
        $cart->addItem($product2, 5);

        $this->assertEquals(2, $cart->totalItems());
        $this->assertEquals(10, $cart->totalQuantity());
    }

    public function testGetTotalBasic()
    {
        $pricing = new Pricing;

        $product = new Product;
        $product->setPrice(500);

        $product2 = new Product;
        $product2->setPrice(300);

        $cart = new Cart;
        $cart->addItem($product, 2);
        $cart->addItem($product2, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1300;
        $cartTotal->subtotal = 1300;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 0;
        $cartTotal->tax = 0;
        $cartTotal->total = 1300;
        $cartTotal->savings = 0;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalCoupon()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);

        $coupon = new Coupon;
        $coupon->setName('20% Off');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addItem($product, 5);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 2500;
        $cartTotal->subtotal = 2500;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 500;
        $cartTotal->tax = 0;
        $cartTotal->total = 2000;
        $cartTotal->savings = 500;
        $cartTotal->coupons = [$coupon];

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalCouponWithCatalogPromotion()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
        $pricing->setCatalogPromotions([$catalogPromotion]);

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);

        $coupon = new Coupon;
        $coupon->setName('20% Off');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addItem($product, 5);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 2500;
        $cartTotal->subtotal = 2000;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 400;
        $cartTotal->tax = 0;
        $cartTotal->total = 1600;
        $cartTotal->savings = 900;
        $cartTotal->coupons = [$coupon];

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalCouponValidOrderValue()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(2000); // $20

        $coupon = new Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000); // $10
        $coupon->setMaxOrderValue(10000); // $100
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addItem($product, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 2000;
        $cartTotal->subtotal = 2000;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 400;
        $cartTotal->tax = 0;
        $cartTotal->total = 1600;
        $cartTotal->savings = 400;
        $cartTotal->coupons = [$coupon];

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalWithShipping()
    {
        $pricing = new Pricing;

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);

        $uspsShippingRate = new Shipping\Rate;
        $uspsShippingRate->code = '4';
        $uspsShippingRate->name = 'Parcel Post';
        $uspsShippingRate->cost = 1000;

        $cart = new Cart;
        $cart->addItem($product, 3);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1500;
        $cartTotal->subtotal = 1500;
        $cartTotal->shipping = 1000;
        $cartTotal->discount = 0;
        $cartTotal->tax = 0;
        $cartTotal->total = 2500;
        $cartTotal->savings = 0;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing, $uspsShippingRate));
    }

    public function testGetTotalWithZip5TaxNotAppliedToShipping()
    {
        $pricing = new Pricing;

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cart = new Cart;
        $cart->setTaxRate($taxRate);
        $cart->addItem($product, 2);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1000;
        $cartTotal->subtotal = 1000;
        $cartTotal->taxSubtotal = 1000;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 0;
        $cartTotal->tax = 80;
        $cartTotal->total = 1080;
        $cartTotal->savings = 0;
        $cartTotal->taxRate = $taxRate;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalWithZip5TaxAppliedToShipping()
    {
        $pricing = new Pricing;

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(true);

        $uspsShippingRate = new Shipping\Rate;
        $uspsShippingRate->code = '4';
        $uspsShippingRate->name = 'Parcel Post';
        $uspsShippingRate->cost = 1000;

        $cart = new Cart;
        $cart->setTaxRate($taxRate);
        $cart->addItem($product, 2);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1000;
        $cartTotal->subtotal = 1000;
        $cartTotal->taxSubtotal = 1000;
        $cartTotal->shipping = 1000;
        $cartTotal->discount = 0;
        $cartTotal->tax = 160;
        $cartTotal->total = 2160;
        $cartTotal->savings = 0;
        $cartTotal->taxRate = $taxRate;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing, $uspsShippingRate));
    }

    public function testGetTotalWithZip5TaxNotTaxable()
    {
        $pricing = new Pricing;

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->setIsTaxable(false);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cart = new Cart;
        $cart->setTaxRate($taxRate);
        $cart->addItem($product, 2);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1000;
        $cartTotal->subtotal = 1000;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 0;
        $cartTotal->tax = 0;
        $cartTotal->total = 1000;
        $cartTotal->savings = 0;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalWithZip5TaxAndCouponReduceSubtotal()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(2000); // $20
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $coupon = new Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000); // $10
        $coupon->setMaxOrderValue(10000); // $100
        $coupon->setReducesTaxSubtotal(true);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->setTaxRate($taxRate);
        $cart->addCoupon($coupon);
        $cart->addItem($product, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 2000;
        $cartTotal->subtotal = 2000;
        $cartTotal->taxSubtotal = 1600;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 400;
        $cartTotal->tax = 128;
        $cartTotal->total = 1728;
        $cartTotal->savings = 400;
        $cartTotal->coupons = [$coupon];
        $cartTotal->taxRate = $taxRate;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalWithZip5TaxAndCouponNoReduceSubtotal()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(2000); // $20
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $coupon = new Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000); // $10
        $coupon->setMaxOrderValue(10000); // $100
        $coupon->setReducesTaxSubtotal(false);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->setTaxRate($taxRate);
        $cart->addCoupon($coupon);
        $cart->addItem($product, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 2000;
        $cartTotal->subtotal = 2000;
        $cartTotal->taxSubtotal = 2000;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 400;
        $cartTotal->tax = 160;
        $cartTotal->total = 1760;
        $cartTotal->savings = 400;
        $cartTotal->coupons = [$coupon];
        $cartTotal->taxRate = $taxRate;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalCartPriceRule()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setPrice(1200);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setPrice(500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCartPriceRule($cartPriceRule);
        $cart->addItem($productShirt, 1);
        $cart->addItem($productPoster, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1700;
        $cartTotal->subtotal = 1200;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 0;
        $cartTotal->tax = 0;
        $cartTotal->total = 1200;
        $cartTotal->savings = 500;
        $cartTotal->cartPriceRules = [$cartPriceRule];

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalCartPriceRuleTaxReduceSubtotal()
    {
        $productShirt = new Product;
        // $productShirt->id = 1;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setPrice(1200);
        $productShirt->setIsTaxable(true);

        $productPoster = new Product;
        // $productPoster->id = 2;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setPrice(500);
        $productPoster->setIsTaxable(true);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setReducesTaxSubtotal(true);
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $cart = new Cart;
        $cart->setTaxRate($taxRate);
        $cart->addCartPriceRule($cartPriceRule);
        $cart->addItem($productShirt, 1);
        $cart->addItem($productPoster, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1700;
        $cartTotal->subtotal = 1200;
        $cartTotal->taxSubtotal = 1200;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 0;
        $cartTotal->tax = 96;
        $cartTotal->total = 1296;
        $cartTotal->savings = 500;
        $cartTotal->cartPriceRules = [$cartPriceRule];
        $cartTotal->taxRate = $taxRate;

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }

    public function testGetTotalCartPriceRuleInvalidCartItems()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setPrice(1200);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setPrice(500);

        $productJacket = new Product;
        $productJacket->setSku('JKT001');
        $productJacket->setName('Navy Jacket');
        $productJacket->setPrice(2500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCartPriceRule($cartPriceRule);
        $cart->addItem($productShirt, 1);
        $cart->addItem($productJacket, 1);

        // Expect:
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 3700;
        $cartTotal->subtotal = 3700;
        $cartTotal->shipping = 0;
        $cartTotal->discount = 0;
        $cartTotal->tax = 0;
        $cartTotal->total = 3700;
        $cartTotal->savings = 0;
        $cartTotal->cartPriceRules = [];

        $this->assertEquals($cartTotal, $cart->getTotal($pricing));
    }
}
