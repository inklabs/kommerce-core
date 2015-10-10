<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\ShippingRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use InvalidArgumentException;
use LogicException;

class CartService extends AbstractService
{
    /** @var CartRepositoryInterface */
    protected $cartRepository;

    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var OptionProductRepositoryInterface */
    protected $optionProductRepository;

    /** @var OptionValueRepositoryInterface */
    protected $optionValueRepository;

    /** @var TextOptionRepositoryInterface */
    protected $textOptionRepository;

    /** @var OrderRepositoryInterface */
    protected $orderRepository;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    /** @var CartCalculatorInterface */
    protected $pricing;

    /** @var TaxRate */
    protected $taxRate;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        OptionProductRepositoryInterface $optionProductRepository,
        OptionValueRepositoryInterface $optionValueRepository,
        TextOptionRepositoryInterface $textOptionRepository,
        CouponRepositoryInterface $couponRepository,
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        CartCalculatorInterface $cartCalculator
    ) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->optionProductRepository = $optionProductRepository;
        $this->optionValueRepository = $optionValueRepository;
        $this->textOptionRepository = $textOptionRepository;
        $this->couponRepository = $couponRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->pricing = $cartCalculator;
    }

    /**
     * @param string $sessionId
     * @return Cart
     */
    public function findBySession($sessionId)
    {
        return $this->cartRepository->findOneBySession($sessionId);
    }

    /**
     * @param string $userId
     * @return Cart
     */
    public function findByUser($userId)
    {
        return $this->cartRepository->findOneByUser($userId);
    }

    /**
     * @param int $cartId
     * @param string $couponCode
     * @return int
     * @throws LogicException
     */
    public function addCouponByCode($cartId, $couponCode)
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);

        if ($coupon === null) {
            throw new LogicException('Coupon not found');
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
     * @param int $cartId
     */
    public function removeCart($cartId)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $this->cartRepository->remove($cart);
    }

    /**
     * @param int $cartId
     * @param int $couponIndex
     */
    public function removeCoupon($cartId, $couponIndex)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->removeCoupon($couponIndex);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $userId
     * @param string $sessionId
     * @return Cart
     */
    public function create($userId, $sessionId)
    {
        if (empty($userId) && empty($sessionId)) {
            throw new InvalidArgumentException('User or session id required.');
        }

        $cart = new Cart;
        $cart->setSessionId($sessionId);

        $this->addUserToCartIfExists($userId, $cart);

        $this->cartRepository->create($cart);

        return $cart;
    }

    /**
     * @param int $userId
     * @param Cart $cart
     */
    private function addUserToCartIfExists($userId, Cart & $cart)
    {
        if (! empty($userId)) {
            $user = $this->userRepository->find($userId);

            if ($user !== null) {
                $cart->setUser($user);
            }
        }
    }

    /**
     * @param int $cartId
     * @param string $productId
     * @param int $quantity
     * @return int $cartItemIndex
     * @throws LogicException
     */
    public function addItem($cartId, $productId, $quantity = 1)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new LogicException('Product not found');
        }

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $cartItemIndex = $cart->addCartItem($cartItem);

        $this->cartRepository->save($cart);

        return $cartItemIndex;
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param string[] $optionProductIds
     * @throws LogicException
     */
    public function addItemOptionProducts($cartId, $cartItemIndex, array $optionProductIds)
    {
        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds($optionProductIds);

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);

        foreach ($optionProducts as $optionProduct) {
            $cartItemOptionProduct = new CartItemOptionProduct;
            $cartItemOptionProduct->setOptionProduct($optionProduct);

            $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        }

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param string[] $optionValueIds
     * @throws LogicException
     */
    public function addItemOptionValues($cartId, $cartItemIndex, array $optionValueIds)
    {
        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds($optionValueIds);

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);

        foreach ($optionValues as $optionValue) {
            $cartItemOptionValue = new CartItemOptionValue;
            $cartItemOptionValue->setOptionValue($optionValue);

            $cartItem->addCartItemOptionValue($cartItemOptionValue);
        }

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param array $textOptionValues
     * @throws LogicException
     */
    public function addItemTextOptionValues($cartId, $cartItemIndex, array $textOptionValues)
    {
        $textOptionIds = array_keys($textOptionValues);
        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds($textOptionIds);

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cartItem = $this->getCartItemAndThrowExceptionIfNotFound($cart, $cartItemIndex);

        foreach ($textOptions as $textOption) {
            $textOptionValue = $textOptionValues[$textOption->getId()];

            $cartItemTextOptionValue = new CartItemTextOptionValue;
            $cartItemTextOptionValue->setTextOption($textOption);
            $cartItemTextOptionValue->setTextOptionValue($textOptionValue);

            $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);
        }

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $fromCartId
     * @param int $toCartId
     */
    public function copyCartItems($fromCartId, $toCartId)
    {
        $fromCart = $this->getCartAndThrowExceptionIfCartNotFound($fromCartId);
        $toCart = $this->getCartAndThrowExceptionIfCartNotFound($toCartId);

        foreach ($fromCart->getCartItems() as $cartItem) {
            $toCart->addCartItem(clone $cartItem);
        }

        $this->cartRepository->save($toCart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param int $quantity
     * @throws LogicException
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
     */
    public function deleteItem($cartId, $cartItemIndex)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->deleteCartItem($cartItemIndex);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @return Cart
     */
    public function getCartFull($cartId)
    {
        return $this->getCartAndThrowExceptionIfCartNotFound($cartId);
    }

    /**
     * @param int $cartId
     * @param ShippingRate $shippingRate
     */
    public function setShippingRate($cartId, ShippingRate $shippingRate)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->setShippingRate($shippingRate);

        $this->cartRepository->save($cart);
    }

    public function setTaxRate($cartId, TaxRate $taxRate = null)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);
        $cart->setTaxRate($taxRate);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param AbstractPayment $payment
     * @param OrderAddress $shippingAddress
     * @param OrderAddress $billingAddress
     * @return OrderService
     */
    public function createOrder(
        $cartId,
        AbstractPayment $payment,
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

    /**
     * @param int $cartId
     * @param int $userId
     * @throws LogicException
     */
    public function setUserById($cartId, $userId)
    {
        $user = $this->userRepository->find($userId);

        if ($user === null) {
            throw new LogicException('User not found');
        }

        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);

        $cart->setUser($user);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $sessionId
     * @throws LogicException
     */
    public function setSessionId($cartId, $sessionId)
    {
        $cart = $this->getCartAndThrowExceptionIfCartNotFound($cartId);

        $cart->setSessionId($sessionId);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @return Cart
     * @throws LogicException
     */
    protected function getCartAndThrowExceptionIfCartNotFound($cartId)
    {
        $cart = $this->cartRepository->find($cartId);

        if ($cart === null) {
            throw new LogicException('Cart not found');
        }

        return $cart;
    }

    /**
     * @param Cart $cart
     * @param int $cartItemIndex
     * @return CartItem
     * @throws LogicException
     */
    protected function getCartItemAndThrowExceptionIfNotFound(Cart $cart, $cartItemIndex)
    {
        $cartItem = $cart->getCartItem($cartItemIndex);

        if ($cartItem === null) {
            throw new LogicException('Cart Item not found');
        }

        return $cartItem;
    }
}
