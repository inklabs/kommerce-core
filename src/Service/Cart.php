<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Payment\Payment;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class Cart extends AbstractService
{
    /** @var EntityRepository\CouponInterface */
    protected $couponRepository;

    /** @var EntityRepository\ProductInterface */
    protected $productRepository;

    /** @var EntityRepository\OptionProductInterface */
    protected $optionProductRepository;

    /** @var EntityRepository\OptionValueInterface */
    protected $optionValueRepository;

    /** @var EntityRepository\TextOptionInterface */
    protected $textOptionRepository;

    /** @var EntityRepository\CartInterface */
    protected $cartRepository;

    /** @var EntityRepository\OrderInterface */
    protected $orderRepository;

    /** @var Entity\Shipping\Rate */
    protected $shippingRate;

    /** @var Entity\TaxRate */
    protected $taxRate;

    /** @var Pricing */
    protected $pricing;

    /** @var Entity\User */
    protected $user;

    /** @var Entity\Cart */
    protected $cart;

    /**
     * @param EntityRepository\CartInterface $cartRepository
     * @param EntityRepository\ProductInterface $productRepository
     * @param EntityRepository\OptionProductInterface $optionProductRepository
     * @param EntityRepository\OptionValueInterface $optionValueRepository
     * @param EntityRepository\TextOptionInterface $textOptionRepository
     * @param EntityRepository\CouponInterface $couponRepository
     * @param EntityRepository\OrderInterface $orderRepository
     * @param Pricing $pricing
     * @param int $cartId
     */
    public function __construct(
        EntityRepository\CartInterface $cartRepository,
        EntityRepository\ProductInterface $productRepository,
        EntityRepository\OptionProductInterface $optionProductRepository,
        EntityRepository\OptionValueInterface $optionValueRepository,
        EntityRepository\TextOptionInterface $textOptionRepository,
        EntityRepository\CouponInterface $couponRepository,
        EntityRepository\OrderInterface $orderRepository,
        Pricing $pricing,
        $cartId
    ) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->optionProductRepository = $optionProductRepository;
        $this->optionValueRepository = $optionValueRepository;
        $this->textOptionRepository = $textOptionRepository;
        $this->couponRepository = $couponRepository;
        $this->orderRepository = $orderRepository;
        $this->pricing = $pricing;

        $this->loadCartAndThrowExceptionIfCartNotFound($cartId);
    }

    protected function save()
    {
        $this->cartRepository->save($this->cart);
    }

    /**
     * @param string $couponCode
     * @return int
     */
    public function addCouponByCode($couponCode)
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);

        if ($coupon === null) {
            throw new \LogicException('Coupon not found');
        }

        $couponIndex = $this->cart->addCoupon($coupon);

        $this->save();

        return $couponIndex;
    }

    public function getCoupons()
    {
        return $this->cart->getCoupons();
    }

    /**
     * @param int $couponIndex
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function removeCoupon($couponIndex)
    {
        $this->cart->removeCoupon($couponIndex);

        $this->save();
    }

    /**
     * @param string $productEncodedId
     * @param int $quantity
     * @return int
     * @throws \LogicException
     */
    public function addItem($productEncodedId, $quantity = 1)
    {
        $product = $this->productRepository->find(Lib\BaseConvert::decode($productEncodedId));

        if ($product === null) {
            throw new \LogicException('Product not found');
        }

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $cartItemIndex = $this->cart->addCartItem($cartItem);

        $this->save();

        return $cartItemIndex;
    }

    /**
     * @param int $cartItemIndex
     * @param string[] $optionProductEncodedIds
     * @throws \LogicException
     */
    public function addItemOptionProducts($cartItemIndex, array $optionProductEncodedIds)
    {
        $optionProductIds = Lib\BaseConvert::decodeAll($optionProductEncodedIds);
        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds($optionProductIds);

        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cartItemIndex);

        foreach ($optionProducts as $optionProduct) {
            $cartItemOptionProduct = new Entity\CartItemOptionProduct;
            $cartItemOptionProduct->setOptionProduct($optionProduct);

            $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        }

        $this->save();
    }

    /**
     * @param int $cartItemIndex
     * @param string[] $optionValueEncodedIds
     * @throws \LogicException
     */
    public function addItemOptionValues($cartItemIndex, array $optionValueEncodedIds)
    {
        $optionValueIds = Lib\BaseConvert::decodeAll($optionValueEncodedIds);
        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds($optionValueIds);

        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cartItemIndex);

        foreach ($optionValues as $optionValue) {
            $cartItemOptionValue = new Entity\CartItemOptionValue;
            $cartItemOptionValue->setOptionValue($optionValue);

            $cartItem->addCartItemOptionValue($cartItemOptionValue);
        }

        $this->save();
    }

    /**
     * @param int $cartItemIndex
     * @param array $textOptionValues
     * @throws \LogicException
     */
    public function addItemTextOptionValues($cartItemIndex, array $textOptionValues)
    {
        $textOptionEncodedIds = array_keys($textOptionValues);
        $textOptionIds = Lib\BaseConvert::decodeAll($textOptionEncodedIds);
        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds($textOptionIds);

        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cartItemIndex);

        foreach ($textOptions as $textOption) {
            $textOptionEncodedId = Lib\BaseConvert::encode($textOption->getId());
            $textOptionValue = $textOptionValues[$textOptionEncodedId];

            $cartItemTextOptionValue = new Entity\CartItemTextOptionValue;
            $cartItemTextOptionValue->setTextOption($textOption);
            $cartItemTextOptionValue->setTextOptionValue($textOptionValue);

            $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);
        }

        $this->save();
    }

    /**
     * @param int $cartItemIndex
     * @param int $quantity
     * @throws \Exception
     */
    public function updateQuantity($cartItemIndex, $quantity)
    {
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cartItemIndex);
        $cartItem->setQuantity($quantity);

        $this->save();
    }

    /**
     * @param int $cartItemIndex
     * @throws \Exception
     */
    public function deleteItem($cartItemIndex)
    {
        $this->cart->deleteCartItem($cartItemIndex);
        $this->save();
    }

    /**
     * @return View\CartItem[]
     */
    public function getItems()
    {
        $viewCartItems = [];
        foreach ($this->cart->getCartItems() as $cartItem) {
            $viewCartItems[] = $cartItem->getView()
                ->withAllData($this->pricing)
                ->export();
        }

        return $viewCartItems;
    }

    /**
     * @return View\Product[]
     */
    public function getProducts()
    {
        $products = [];
        foreach ($this->getItems() as $item) {
            $products[] = $item->product;
        }
        return $products;
    }

    /**
     * @return View\CartItem|null
     */
    public function getItem($cartItemIndex)
    {
        $cartItem = $this->cart->getCartItem($cartItemIndex);

        if ($cartItem === null) {
            return null;
        }

        return $cartItem->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    public function getShippingWeight()
    {
        return $this->cart->getShippingWeight();
    }

    public function getShippingWeightInPounds()
    {
        return (int) ceil($this->cart->getShippingWeight() / 16);
    }

    public function totalItems()
    {
        return $this->cart->totalItems();
    }

    public function totalQuantity()
    {
        return $this->cart->totalQuantity();
    }

    public function getTotal()
    {
        return $this->cart->getTotal($this->pricing, $this->shippingRate, $this->taxRate);
    }

    public function setShippingRate(Entity\Shipping\Rate $shippingRate)
    {
        $this->shippingRate = $shippingRate;
        $this->save();
    }

    public function setTaxRate(Entity\TaxRate $taxRate)
    {
        $this->taxRate = $taxRate;
        $this->save();
    }

    public function createOrder(Payment $payment, OrderAddress $shippingAddress, OrderAddress $billingAddress = null)
    {
        if ($billingAddress === null) {
            $billingAddress = clone $shippingAddress;
        }

        $order = $this->cart->getOrder($this->pricing, $this->shippingRate, $this->taxRate);
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->addPayment($payment);

        $this->orderRepository->create($order);

        return $order;
    }

    public function getView()
    {
        return $this->cart->getView()
            ->withAllData($this->pricing, $this->shippingRate, $this->taxRate)
            ->export();
    }

    public function setUser(Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int $cartId
     */
    protected function loadCartAndThrowExceptionIfCartNotFound($cartId)
    {
        $this->cart = $this->cartRepository->find($cartId);

        if ($this->cart === null) {
            throw new \LogicException('Cart not found');
        }
    }

    /**
     * @param int $cartItemIndex
     * @return Entity\CartItem
     * @throws \LogicException
     */
    protected function getCartItemAndThrowExceptionIfNotFound($cartItemIndex)
    {
        $cartItem = $this->cart->getCartItem($cartItemIndex);

        if ($cartItem === null) {
            throw new \LogicException('Cart Item not found');
        }

        return $cartItem;
    }
}
