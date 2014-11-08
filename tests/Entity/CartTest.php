<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

class CartTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
    }

    public function testAddItem()
    {
        $product = new Product;
        $product2 = new Product;

        $cart = new Cart($this->pricing);
        $cart->addItem($product, 5);
        $cart->addItem($product2, 5);

        $this->assertEquals(2, $cart->totalItems());
        $this->assertEquals(10, $cart->totalQuantity());
    }

    public function testAddItemReturnId()
    {
        $product = new Product;
        $product2 = new Product;

        $cart = new Cart($this->pricing);
        $id1 = $cart->addItem($product, 5);
        $id2 = $cart->addItem($product2, 5);

        $this->assertEquals(0, $id1);
        $this->assertEquals(1, $id2);
    }

    public function testAddDuplicateItem()
    {
        $product = new Product;

        $cart = new Cart($this->pricing);
        $cart->addItem($product, 5);
        $cart->addItem($product, 2);

        $this->assertEquals(2, $cart->totalItems());
        $this->assertEquals(7, $cart->totalQuantity());
    }

    public function testGetItem()
    {
        $product = new Product;

        $cart = new Cart($this->pricing);
        $cart->addItem($product, 5);

        $item = $cart->getItem(0);
        $this->assertEquals($product, $item->getProduct());
    }

    public function testGetItemMissing()
    {
        $cart = new Cart($this->pricing);

        $item = $cart->getItem(0);
        $this->assertEquals(null, $item);
    }

    public function testGetItems()
    {
        $product = new Product;

        $cart = new Cart($this->pricing);
        $cart->addItem($product, 5);
        $cart->addItem($product, 2);

        $items = $cart->getItems();
        $this->assertEquals(2, count($items));
    }

    public function testGetTotalBasic()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $product2 = new Product;
        $product2->setUnitPrice(300);

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCoupon()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCouponWithCatalogPromotion()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCouponValidOrderValue()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(2000); // $20

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalWithShipping()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing, $uspsShippingRate));
    }

    public function testGetTotalWithZip5TaxNotAppliedToShipping()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalWithZip5TaxAppliedToShipping()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing, $uspsShippingRate));
    }

    public function testGetTotalWithZip5TaxNotTaxable()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalWithZip5TaxAndCouponReduceSubtotal()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(2000); // $20
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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalWithZip5TaxAndCouponNoReduceSubtotal()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(2000); // $20
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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCartPriceRule()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCartPriceRuleTaxReduceSubtotal()
    {
        $productShirt = new Product;
        // $productShirt->id = 1;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);
        $productShirt->setIsTaxable(true);

        $productPoster = new Product;
        // $productPoster->id = 2;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);
        $productPoster->setIsTaxable(true);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setReducesTaxSubtotal(true);
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCartPriceRuleInvalidCartItems()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);

        $productJacket = new Product;
        $productJacket->setSku('JKT001');
        $productJacket->setName('Navy Jacket');
        $productJacket->setUnitPrice(2500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

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

        $this->assertEquals($cartTotal, $cart->getTotal($this->pricing));
    }
}
