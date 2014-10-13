<?php
use inklabs\kommerce\Pricing;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\Shipping;

class CartTest extends PHPUnit_Framework_TestCase
{
    private function setup_product()
    {
        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';

        return $product;
    }

    /**
     * @covers Cart::add_item
     * @covers Cart::total_items
     * @covers Cart::total_quantity
     */
    public function test_add_item()
    {
        $product = $this->setup_product();
        $product->name = 'Test 1';

        $product2 = $this->setup_product();
        $product2->name = 'Test 2';

        $cart = new Cart;
        $cart->add_item($product, 5);
        $cart->add_item($product2, 5);

        $this->assertEquals(2, $cart->total_items());
        $this->assertEquals(10, $cart->total_quantity());
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_basic()
    {
        $pricing = new Pricing;

        $product = $this->setup_product();
        $product->name = 'Test 1';
        $product->price = 500;

        $product2 = $this->setup_product();
        $product2->name = 'Test 2';
        $product2->price = 300;

        $cart = new Cart;
        $cart->add_item($product, 2);
        $cart->add_item($product2, 1);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1300;
        $cart_total->subtotal = 1300;
        $cart_total->shipping = 0;
        $cart_total->discount = 0;
        $cart_total->tax = 0;
        $cart_total->total = 1300;
        $cart_total->savings = 0;

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::add_coupon
     * @covers Cart::get_total
     */
    public function test_get_total_coupon()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

        $product = $this->setup_product();
        $product->price = 500;

        $coupon = new Coupon;
        $coupon->name = '20% Off';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $coupon->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

        $cart = new Cart;
        $cart->add_coupon($coupon);
        $cart->add_item($product, 5);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 2500;
        $cart_total->subtotal = 2500;
        $cart_total->shipping = 0;
        $cart_total->discount = 500;
        $cart_total->tax = 0;
        $cart_total->total = 2000;
        $cart_total->savings = 500;
        $cart_total->coupons = [$coupon];

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_coupon_with_catalog_promotion()
    {
        $catalog_promotion = new CatalogPromotion;
        $catalog_promotion->name = '20% Off';
        $catalog_promotion->discount_type = 'percent';
        $catalog_promotion->value = 20;
        $catalog_promotion->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $catalog_promotion->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

        $pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));
        $pricing->add_catalog_promotion($catalog_promotion);

        $product = $this->setup_product();
        $product->price = 500;

        $coupon = new Coupon;
        $coupon->name = '20% Off';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $coupon->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

        $cart = new Cart;
        $cart->add_coupon($coupon);
        $cart->add_item($product, 5);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 2500;
        $cart_total->subtotal = 2000;
        $cart_total->shipping = 0;
        $cart_total->discount = 400;
        $cart_total->tax = 0;
        $cart_total->total = 1600;
        $cart_total->savings = 900;
        $cart_total->coupons = [$coupon];

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_coupon_valid_order_value()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

        $product = $this->setup_product();
        $product->price = 2000; // $20

        $coupon = new Coupon;
        $coupon->name = '20% Off orders under $100';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->min_order_value = 1000; // $10
        $coupon->max_order_value = 10000; // $100
        $coupon->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $coupon->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

        $cart = new Cart;
        $cart->add_coupon($coupon);
        $cart->add_item($product, 1);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 2000;
        $cart_total->subtotal = 2000;
        $cart_total->shipping = 0;
        $cart_total->discount = 400;
        $cart_total->tax = 0;
        $cart_total->total = 1600;
        $cart_total->savings = 400;
        $cart_total->coupons = [$coupon];

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_with_shipping()
    {
        $pricing = new Pricing;

        $product = $this->setup_product();
        $product->price = 500;

        $usps_shipping_rate = new Shipping\Rate;
        $usps_shipping_rate->code = '4';
        $usps_shipping_rate->name = 'Parcel Post';
        $usps_shipping_rate->cost = 1000;

        $cart = new Cart;
        $cart->add_item($product, 3);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1500;
        $cart_total->subtotal = 1500;
        $cart_total->shipping = 1000;
        $cart_total->discount = 0;
        $cart_total->tax = 0;
        $cart_total->total = 2500;
        $cart_total->savings = 0;

        $this->assertEquals($cart_total, $cart->get_total($pricing, $usps_shipping_rate));
    }

    /**
     * @covers Cart::set_tax_rate
     * @covers Cart::get_total
     */
    public function test_get_total_with_zip5_tax_not_applied_to_shipping()
    {
        $pricing = new Pricing;

        $product = $this->setup_product();
        $product->price = 500;
        $product->is_taxable = TRUE;

        $tax_rate = new TaxRate;
        $tax_rate->zip5 = 92606;
        $tax_rate->rate = 8.0;
        $tax_rate->apply_to_shipping = FALSE;

        $cart = new Cart;
        $cart->set_tax_rate($tax_rate);
        $cart->add_item($product, 2);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1000;
        $cart_total->subtotal = 1000;
        $cart_total->tax_subtotal = 1000;
        $cart_total->shipping = 0;
        $cart_total->discount = 0;
        $cart_total->tax = 80;
        $cart_total->total = 1080;
        $cart_total->savings = 0;
        $cart_total->tax_rate = $tax_rate;

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_with_zip5_tax_applied_to_shipping()
    {
        $pricing = new Pricing;

        $product = $this->setup_product();
        $product->price = 500;
        $product->is_taxable = TRUE;

        $tax_rate = new TaxRate;
        $tax_rate->zip5 = 92606;
        $tax_rate->rate = 8.0;
        $tax_rate->apply_to_shipping = TRUE;

        $usps_shipping_rate = new Shipping\Rate;
        $usps_shipping_rate->code = '4';
        $usps_shipping_rate->name = 'Parcel Post';
        $usps_shipping_rate->cost = 1000;

        $cart = new Cart;
        $cart->set_tax_rate($tax_rate);
        $cart->add_item($product, 2);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1000;
        $cart_total->subtotal = 1000;
        $cart_total->tax_subtotal = 1000;
        $cart_total->shipping = 1000;
        $cart_total->discount = 0;
        $cart_total->tax = 160;
        $cart_total->total = 2160;
        $cart_total->savings = 0;
        $cart_total->tax_rate = $tax_rate;

        $this->assertEquals($cart_total, $cart->get_total($pricing, $usps_shipping_rate));
    }

    /**
     * @covers Cart::set_tax_rate
     * @covers Cart::get_total
     */
    public function test_get_total_with_zip5_tax_not_taxable()
    {
        $pricing = new Pricing;

        $product = $this->setup_product();
        $product->price = 500;
        $product->is_taxable = FALSE;

        $tax_rate = new TaxRate;
        $tax_rate->zip5 = 92606;
        $tax_rate->rate = 8.0;
        $tax_rate->apply_to_shipping = FALSE;

        $cart = new Cart;
        $cart->set_tax_rate($tax_rate);
        $cart->add_item($product, 2);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1000;
        $cart_total->subtotal = 1000;
        $cart_total->shipping = 0;
        $cart_total->discount = 0;
        $cart_total->tax = 0;
        $cart_total->total = 1000;
        $cart_total->savings = 0;

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_with_zip5_tax_and_coupon_reduce_subtotal()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

        $product = $this->setup_product();
        $product->price = 2000; // $20
        $product->is_taxable = TRUE;

        $tax_rate = new TaxRate;
        $tax_rate->zip5 = 92606;
        $tax_rate->rate = 8.0;
        $tax_rate->apply_to_shipping = FALSE;

        $coupon = new Coupon;
        $coupon->name = '20% Off orders under $100';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->min_order_value = 1000; // $10
        $coupon->max_order_value = 10000; // $100
        $coupon->reduces_tax_subtotal = TRUE;
        $coupon->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $coupon->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

        $cart = new Cart;
        $cart->set_tax_rate($tax_rate);
        $cart->add_coupon($coupon);
        $cart->add_item($product, 1);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 2000;
        $cart_total->subtotal = 2000;
        $cart_total->tax_subtotal = 1600;
        $cart_total->shipping = 0;
        $cart_total->discount = 400;
        $cart_total->tax = 128;
        $cart_total->total = 1728;
        $cart_total->savings = 400;
        $cart_total->coupons = [$coupon];
        $cart_total->tax_rate = $tax_rate;

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_with_zip5_tax_and_coupon_no_reduce_subtotal()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

        $product = $this->setup_product();
        $product->price = 2000; // $20
        $product->is_taxable = TRUE;

        $tax_rate = new TaxRate;
        $tax_rate->zip5 = 92606;
        $tax_rate->rate = 8.0;
        $tax_rate->apply_to_shipping = FALSE;

        $coupon = new Coupon;
        $coupon->name = '20% Off orders under $100';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->min_order_value = 1000; // $10
        $coupon->max_order_value = 10000; // $100
        $coupon->reduces_tax_subtotal = FALSE;
        $coupon->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $coupon->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

        $cart = new Cart;
        $cart->set_tax_rate($tax_rate);
        $cart->add_coupon($coupon);
        $cart->add_item($product, 1);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 2000;
        $cart_total->subtotal = 2000;
        $cart_total->tax_subtotal = 2000;
        $cart_total->shipping = 0;
        $cart_total->discount = 400;
        $cart_total->tax = 160;
        $cart_total->total = 1760;
        $cart_total->savings = 400;
        $cart_total->coupons = [$coupon];
        $cart_total->tax_rate = $tax_rate;

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    /**
     * @covers Cart::get_total
     */
    public function test_get_total_cart_price_rule()
    {
        $product_shirt = new Product;
        $product_shirt->id = 1;
        $product_shirt->sku = 'TS-NAVY-LG';
        $product_shirt->name = 'Navy T-shirt (large)';
        $product_shirt->price = 1200;

        $product_poster = new Product;
        $product_poster->id = 2;
        $product_poster->sku = 'PST-CKN';
        $product_poster->name = 'Citizen Kane (1941) Poster';
        $product_poster->price = 500;

        $cart_price_rule = new CartPriceRule;
        $cart_price_rule->name = 'Buy a Shirt get a FREE poster';
        $cart_price_rule->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
        $cart_price_rule->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));
        $cart_price_rule->add_item(new CartPriceRuleItem($product_shirt, 1));
        $cart_price_rule->add_item(new CartPriceRuleItem($product_poster, 1));
        $cart_price_rule->add_discount(new CartPriceRuleDiscount($product_poster, 1));

        $pricing = new Pricing(new \DateTime('2014-02-01', new DateTimeZone('UTC')));

        $cart = new Cart;
        $cart->add_cart_price_rule($cart_price_rule);
        $cart->add_item($product_shirt, 1);
        $cart->add_item($product_poster, 1);

        // Expect:
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1700;
        $cart_total->subtotal = 1200;
        $cart_total->shipping = 0;
        $cart_total->discount = 0;
        $cart_total->tax = 0;
        $cart_total->total = 1200;
        $cart_total->savings = 500;
        $cart_total->cart_price_rules = [$cart_price_rule];

        $this->assertEquals($cart_total, $cart->get_total($pricing));
    }

    // $tag_poster = new Tag;
    // $tag_poster->id = 1;
    // $tag_poster->name = 'Poster';
    // $product_poster->tags = [$tag_poster];

}
