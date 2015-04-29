<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Entity\Payment;
use inklabs\kommerce\tests\EntityRepository\FakeCart;
use inklabs\kommerce\tests\EntityRepository\FakeProduct;
use inklabs\kommerce\tests\EntityRepository\FakeOptionProduct;
use inklabs\kommerce\tests\EntityRepository\FakeOptionValue;
use inklabs\kommerce\tests\EntityRepository\FakeTextOption;
use inklabs\kommerce\tests\EntityRepository\FakeCoupon;
use LogicException;

class CartTest extends Helper\DoctrineTestCase
{
    /** @var FakeCart */
    protected $cartRepository;

    /** @var FakeProduct */
    protected $productRepository;

    /** @var FakeOptionProduct */
    protected $optionProductRepository;

    /** @var FakeOptionValue */
    protected $optionValueRepository;

    /** @var FakeTextOption */
    protected $textOptionRepository;

    /** @var FakeCoupon */
    protected $couponRepository;

    /** @var Cart */
    protected $cartService;

    public function setUp()
    {
        $this->cartRepository = new FakeCart;
        $this->productRepository = new FakeProduct;
        $this->optionProductRepository = new FakeOptionProduct;
        $this->optionValueRepository = new FakeOptionValue;
        $this->textOptionRepository = new FakeTextOption;
        $this->couponRepository = new FakeCoupon;

        $cartId = 1;
        $this->cartService = new Cart(
            $this->cartRepository,
            $this->productRepository,
            $this->optionProductRepository,
            $this->optionValueRepository,
            $this->textOptionRepository,
            $this->couponRepository,
            new Service\Pricing,
            $cartId
        );
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cart not found
     */
    public function testCreateThrowsException()
    {
        $this->cartRepository = new FakeCart;
        $this->productRepository = new FakeProduct;
        $this->optionProductRepository = new FakeOptionProduct;
        $this->optionValueRepository = new FakeOptionValue;
        $this->textOptionRepository = new FakeTextOption;
        $this->couponRepository = new FakeCoupon;

        $this->cartRepository->setReturnValue(null);

        $cartId = 1;
        $this->cartService = new Cart(
            $this->cartRepository,
            $this->productRepository,
            $this->optionProductRepository,
            $this->optionValueRepository,
            $this->textOptionRepository,
            $this->couponRepository,
            new Service\Pricing,
            $cartId
        );
    }

    public function testAddCouponByCode()
    {
        $couponIndex = $this->cartService->addCouponByCode('code');
        $this->assertSame(0, $couponIndex);
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage Coupon not found
     */
    public function testAddCouponByCodeMissing()
    {
        $this->couponRepository->setReturnValue(null);
        $couponIndex = $this->cartService->addCouponByCode('code');
    }

    public function testGetCoupons()
    {
        $couponIndex = $this->cartService->addCouponByCode('code');

        $coupons = $this->cartService->getCoupons();
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testRemoveCoupon()
    {
        $couponIndex = $this->cartService->addCouponByCode('code');

        $coupons = $this->cartService->getCoupons();
        $this->assertSame(1, count($coupons));

        $this->cartService->removeCoupon($couponIndex);

        $coupons = $this->cartService->getCoupons();
        $this->assertSame(0, count($coupons));
    }

    public function testAddItem()
    {
        $productEncodedId = 'P1';
        $quantity = 1;

        $cartItemIndex = $this->cartService->addItem($productEncodedId, $quantity);

        $cartItem = $this->cartService->getItem($cartItemIndex);

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cartItem instanceof View\CartItem);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Product not found
     */
    public function testAddItemWithMissingProduct()
    {
        $this->productRepository->setReturnValue(null);
        $productEncodedId = 'P1';

        $cartItemIndex = $this->cartService->addItem($productEncodedId);
    }

    public function testAddItemOptionProducts()
    {
        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $optionProductEncodedIds = ['OP1'];

        $this->cartService->addItemOptionProducts($cartItemIndex, $optionProductEncodedIds);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cart Item not found
     */
    public function testAddItemOptionProductsThrowsException()
    {
        $cartItemIndex = 1;
        $optionProductEncodedIds = ['OP1'];

        $this->cartService->addItemOptionProducts($cartItemIndex, $optionProductEncodedIds);
    }

    public function testAddItemOptionValues()
    {
        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $optionValueEncodedIds = ['OV1'];

        $this->cartService->addItemOptionValues($cartItemIndex, $optionValueEncodedIds);
    }

    public function testAddItemTextOptionValues()
    {
        $textOption = new Entity\TextOption;
        $textOption->setId(1);
        $this->textOptionRepository->setReturnValue($textOption);

        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $textOptionEncodedId = '1';
        $textOptionValues = [$textOptionEncodedId => 'Happy Birthday'];

        $this->cartService->addItemTextOptionValues($cartItemIndex, $textOptionValues);
    }

    public function testUpdateQuantity()
    {
        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $quantity = 2;
        $this->cartService->updateQuantity($cartItemIndex, $quantity);

        $cartItem = $this->cartService->getItem($cartItemIndex);

        $this->assertSame(2, $cartItem->quantity);
    }

    public function testDeleteItem()
    {
        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $this->cartService->deleteItem($cartItemIndex);

        $cartItem = $this->cartService->getItem($cartItemIndex);

        $this->assertSame(null, $cartItem);
    }

    public function testGetItems()
    {
        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $cartItems = $this->cartService->getItems();

        $this->assertTrue($cartItems[0] instanceof View\CartItem);
    }

    public function testGetProducts()
    {
        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId);

        $cartProducts = $this->cartService->getProducts();

        $this->assertTrue($cartProducts[0] instanceof View\Product);
    }

    public function testGetters()
    {
        $product = new Entity\Product;
        $product->setShippingWeight(16);
        $this->productRepository->setReturnValue($product);

        $productEncodedId = 'P1';
        $cartItemIndex = $this->cartService->addItem($productEncodedId, 2);

        $this->assertSame(32, $this->cartService->getShippingWeight());
        $this->assertSame(2, $this->cartService->getShippingWeightInPounds());
        $this->assertSame(1, $this->cartService->totalItems());
        $this->assertSame(2, $this->cartService->totalQuantity());
        $this->assertTrue($this->cartService->getTotal() instanceof Entity\CartTotal);
        $this->assertTrue($this->cartService->getView() instanceof View\Cart);
    }

    public function testSetters()
    {
        $this->cartService->setShippingRate(new Entity\Shipping\Rate);
        $this->cartService->setTaxRate(new Entity\TaxRate);
        $this->cartService->setUser(new Entity\User);
    }
}
