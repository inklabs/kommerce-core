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

    /** @var Entity\TaxRate */
    protected $taxRate;

    /** @var Lib\PricingInterface */
    protected $pricing;

    /**
     * @param EntityRepository\CartInterface $cartRepository
     * @param EntityRepository\ProductInterface $productRepository
     * @param EntityRepository\OptionProductInterface $optionProductRepository
     * @param EntityRepository\OptionValueInterface $optionValueRepository
     * @param EntityRepository\TextOptionInterface $textOptionRepository
     * @param EntityRepository\CouponInterface $couponRepository
     * @param EntityRepository\OrderInterface $orderRepository
     * @param Lib\PricingInterface $pricing
     */
    public function __construct(
        EntityRepository\CartInterface $cartRepository,
        EntityRepository\ProductInterface $productRepository,
        EntityRepository\OptionProductInterface $optionProductRepository,
        EntityRepository\OptionValueInterface $optionValueRepository,
        EntityRepository\TextOptionInterface $textOptionRepository,
        EntityRepository\CouponInterface $couponRepository,
        EntityRepository\OrderInterface $orderRepository,
        Lib\PricingInterface $pricing
    ) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->optionProductRepository = $optionProductRepository;
        $this->optionValueRepository = $optionValueRepository;
        $this->textOptionRepository = $textOptionRepository;
        $this->couponRepository = $couponRepository;
        $this->orderRepository = $orderRepository;
        $this->pricing = $pricing;
    }

    /**
     * @param int $userId
     * @param string $sessionId
     * @return View\Cart
     * @throws \LogicException
     */
    public function findByUserOrSession($userId, $sessionId)
    {
        $cart = $this->cartRepository->findByUserOrSession($userId, $sessionId);

        if ($cart === null) {
            throw new \LogicException('Cart not found');
        }

        return $cart->getView()->export();
    }

    /**
     * @param int $cartId
     * @param string $couponCode
     * @return int
     * @throws \LogicException
     */
    public function addCouponByCode($cartId, $couponCode)
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);

        if ($coupon === null) {
            throw new \LogicException('Coupon not found');
        }

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $couponIndex = $cart->addCoupon($coupon);

        $this->cartRepository->save($cart);

        return $couponIndex;
    }

    public function getCoupons($cartId)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        return $cart->getCoupons();
    }

    /**
     * @param int $couponIndex
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function removeCoupon($cartId, $couponIndex)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->removeCoupon($couponIndex);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param string $productId
     * @param int $quantity
     * @return int $cartItemIndex
     * @throws \LogicException
     */
    public function addItem($cartId, $productId, $quantity = 1)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new \LogicException('Product not found');
        }

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);

        $cartItem = new Entity\CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $cartItemIndex = $cart->addCartItem($cartItem);

        $this->cartRepository->save($cart);

        return $cartItemIndex;
    }

    /**
     * @param $cartId
     * @param int $cartItemIndex
     * @param string[] $optionProductIds
     * @throws \LogicException
     */
    public function addItemOptionProducts($cartId, $cartItemIndex, array $optionProductIds)
    {
        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds($optionProductIds);

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);

        foreach ($optionProducts as $optionProduct) {
            $cartItemOptionProduct = new Entity\CartItemOptionProduct;
            $cartItemOptionProduct->setOptionProduct($optionProduct);

            $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        }

        $this->cartRepository->save($cart);
    }

    /**
     * @param $cartId
     * @param int $cartItemIndex
     * @param string[] $optionValueIds
     * @throws \LogicException
     */
    public function addItemOptionValues($cartId, $cartItemIndex, array $optionValueIds)
    {
        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds($optionValueIds);

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);

        foreach ($optionValues as $optionValue) {
            $cartItemOptionValue = new Entity\CartItemOptionValue;
            $cartItemOptionValue->setOptionValue($optionValue);

            $cartItem->addCartItemOptionValue($cartItemOptionValue);
        }

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param array $textOptionValues
     * @throws \LogicException
     */
    public function addItemTextOptionValues($cartId, $cartItemIndex, array $textOptionValues)
    {
        $textOptionIds = array_keys($textOptionValues);
        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds($textOptionIds);

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);

        foreach ($textOptions as $textOption) {
            $textOptionValue = $textOptionValues[$textOption->getId()];

            $cartItemTextOptionValue = new Entity\CartItemTextOptionValue;
            $cartItemTextOptionValue->setTextOption($textOption);
            $cartItemTextOptionValue->setTextOptionValue($textOptionValue);

            $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);
        }

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param int $quantity
     * @throws \LogicException
     */
    public function updateQuantity($cartId, $cartItemIndex, $quantity)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);
        $cartItem->setQuantity($quantity);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @throws \LogicException
     */
    public function deleteItem($cartId, $cartItemIndex)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->deleteCartItem($cartItemIndex);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @return View\Cart
     * @throws \LogicException
     */
    public function getCartFull($cartId)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);

        return $cart->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param int $cartId
     * @param \inklabs\kommerce\Entity\ShippingRate $shippingRate
     */
    public function setShippingRate($cartId, Entity\ShippingRate $shippingRate)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->setShippingRate($shippingRate);

        $this->cartRepository->save($cart);
    }

    public function setTaxRate($cartId, Entity\TaxRate $taxRate)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->setTaxRate($taxRate);

        $this->cartRepository->save($cart);
    }

    public function createOrder(
        $cartId,
        Payment $payment,
        OrderAddress $shippingAddress,
        OrderAddress $billingAddress = null
    ) {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);

        if ($billingAddress === null) {
            $billingAddress = clone $shippingAddress;
        }

        $order = $cart->getOrder($this->pricing);
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->addPayment($payment);

        $this->orderRepository->create($order);

        return $order;
    }

    public function setUser(Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int $cartId
     * @return Entity\Cart
     * @throws \LogicException
     */
    protected function getCartAndThrowExceptionIfCartNotFound($cartId)
    {
        $cart = $this->cartRepository->find($cartId);

        if ($cart === null) {
            throw new \LogicException('Cart not found');
        }

        return $cart;
    }

    /**
     * @param Entity\Cart $cart
     * @param int $cartItemIndex
     * @return Entity\CartItem
     * @throws \LogicException
     */
    protected function getCartItemAndThrowExceptionIfNotFound(Entity\Cart $cart, $cartItemIndex)
    {
        $cartItem = $cart->getCartItem($cartItemIndex);

        if ($cartItem === null) {
            throw new \LogicException('Cart Item not found');
        }

        return $cartItem;
    }
}
