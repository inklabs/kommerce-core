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

    public function testDeleteItem()
    {
        $cart = new Cart($this->pricing);
        $itemId = $cart->addItem(new Product, 5);
        $cart->deleteItem($itemId);
        $this->assertEquals(0, $cart->totalItems());
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteItemAndItemNotFound()
    {
        $cart = new Cart($this->pricing);
        $cart->deleteItem(1);
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

    public function testGetShippingWeight()
    {
        $product1 = new Product;
        $product1->setShippingWeight(16);

        $product2 = new Product;
        $product2->setShippingWeight(16);

        $cart = new Cart($this->pricing);
        $cart->addItem($product1, 2);
        $cart->addItem($product2, 2);

        $this->assertEquals(64, $cart->getShippingWeight());
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

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1300;
        $expectedCartTotal->subtotal = 1300;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1300;
        $expectedCartTotal->savings = 0;

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing));
    }

    public function testAddCoupon()
    {
        $coupon = new Coupon;
        $coupon->setName('20% Off');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $this->assertEquals(1, count($cart->getCoupons()));
    }

    public function testAddCouponWithStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertEquals(2, count($cart->getCoupons()));
    }

    /**
     * @expectedException Exception
     */
    public function testAddCouponWithNonStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(20);
        $coupon2->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
    }

    public function testAddCouponWithSecondStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertEquals(2, count($cart->getCoupons()));
    }

    public function testAddCouponWithFirstStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(20);
        $coupon2->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertEquals(2, count($cart->getCoupons()));
    }

    private function getPercentCoupon($value)
    {
        $coupon = new Coupon;
        $coupon->setName($value . '% Off');
        $coupon->setDiscountType('percent');
        $coupon->setValue($value);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        return $coupon;
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

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 2500;
        $expectedCartTotal->subtotal = 2500;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 500;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2000;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->coupons = [$coupon];

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing));
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

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 2500;
        $expectedCartTotal->subtotal = 2000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 400;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1600;
        $expectedCartTotal->savings = 900;
        $expectedCartTotal->coupons = [$coupon];

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCouponValidOrderValue()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(2000);

        $coupon = new Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000);
        $coupon->setMaxOrderValue(10000);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addItem($product, 1);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 2000;
        $expectedCartTotal->subtotal = 2000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 400;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1600;
        $expectedCartTotal->savings = 400;
        $expectedCartTotal->coupons = [$coupon];

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing));
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

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1500;
        $expectedCartTotal->subtotal = 1500;
        $expectedCartTotal->shipping = 1000;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 2500;
        $expectedCartTotal->savings = 0;

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $uspsShippingRate));
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
        $cart->addItem($product, 2);

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

        $shippingRate = null;
        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $shippingRate, $taxRate));
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
        $cart->addItem($product, 2);

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

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $uspsShippingRate, $taxRate));
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
        $cart->addItem($product, 2);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1000;
        $expectedCartTotal->subtotal = 1000;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1000;
        $expectedCartTotal->savings = 0;

        $shippingRate = null;
        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $shippingRate, $taxRate));
    }

    public function testGetTotalWithZip5TaxAndCouponReduceSubtotal()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(2000);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $coupon = new Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000);
        $coupon->setMaxOrderValue(10000);
        $coupon->setReducesTaxSubtotal(true);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addItem($product, 1);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 2000;
        $expectedCartTotal->subtotal = 2000;
        $expectedCartTotal->taxSubtotal = 1600;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 400;
        $expectedCartTotal->tax = 128;
        $expectedCartTotal->total = 1728;
        $expectedCartTotal->savings = 400;
        $expectedCartTotal->coupons = [$coupon];
        $expectedCartTotal->taxRate = $taxRate;

        $shippingRate = null;
        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $shippingRate, $taxRate));
    }

    public function testGetTotalWithZip5TaxAndCouponNoReduceSubtotal()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(2000);
        $product->setIsTaxable(true);

        $taxRate = new TaxRate;
        $taxRate->setZip5(92606);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $coupon = new Coupon;
        $coupon->setName('20% Off orders under $100');
        $coupon->setDiscountType('percent');
        $coupon->setValue(20);
        $coupon->setMinOrderValue(1000);
        $coupon->setMaxOrderValue(10000);
        $coupon->setReducesTaxSubtotal(false);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->addCoupon($coupon);
        $cart->addItem($product, 1);

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

        $shippingRate = null;
        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $shippingRate, $taxRate));
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

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1700;
        $expectedCartTotal->subtotal = 1200;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 1200;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->cartPriceRules = [$cartPriceRule];

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing));
    }

    public function testGetTotalCartPriceRuleTaxReduceSubtotal()
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
        $cart->addCartPriceRule($cartPriceRule);
        $cart->addItem($productShirt, 1);
        $cart->addItem($productPoster, 1);

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 1700;
        $expectedCartTotal->subtotal = 1200;
        $expectedCartTotal->taxSubtotal = 1200;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 96;
        $expectedCartTotal->total = 1296;
        $expectedCartTotal->savings = 500;
        $expectedCartTotal->cartPriceRules = [$cartPriceRule];
        $expectedCartTotal->taxRate = $taxRate;

        $shippingRate = null;
        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing, $shippingRate, $taxRate));
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

        $expectedCartTotal = new CartTotal;
        $expectedCartTotal->origSubtotal = 3700;
        $expectedCartTotal->subtotal = 3700;
        $expectedCartTotal->shipping = 0;
        $expectedCartTotal->discount = 0;
        $expectedCartTotal->tax = 0;
        $expectedCartTotal->total = 3700;
        $expectedCartTotal->savings = 0;
        $expectedCartTotal->cartPriceRules = [];

        $this->assertEquals($expectedCartTotal, $cart->getTotal($this->pricing));
    }
}
