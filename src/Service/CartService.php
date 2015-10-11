<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\InvalidCartActionException;
use inklabs\kommerce\Entity\ShippingRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use InvalidArgumentException;

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
     * @throws EntityNotFoundException
     */
    public function addCouponByCode($cartId, $couponCode)
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);
        $cart = $this->cartRepository->findOneById($cartId);

        $couponIndex = $cart->addCoupon($coupon);

        $this->cartRepository->save($cart);

        return $couponIndex;
    }

    public function getCoupons($cartId)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        return $cart->getCoupons();
    }

    /**
     * @param int $cartId
     */
    public function removeCart($cartId)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $this->cartRepository->remove($cart);
    }

    /**
     * @param int $cartId
     * @param int $couponIndex
     */
    public function removeCoupon($cartId, $couponIndex)
    {
        $cart = $this->cartRepository->findOneById($cartId);
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
            try {
                $user = $this->userRepository->findOneById($userId);
                $cart->setUser($user);
            } catch (EntityNotFoundException $e) {
            }
        }
    }

    /**
     * @param int $cartId
     * @param string $productId
     * @param int $quantity
     * @return int $cartItemIndex
     * @throws EntityNotFoundException
     */
    public function addItem($cartId, $productId, $quantity = 1)
    {
        $product = $this->productRepository->findOneById($productId);
        $cart = $this->cartRepository->findOneById($cartId);

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
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionProducts($cartId, $cartItemIndex, array $optionProductIds)
    {
        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds($optionProductIds);

        $cart = $this->cartRepository->findOneById($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);

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
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionValues($cartId, $cartItemIndex, array $optionValueIds)
    {
        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds($optionValueIds);

        $cart = $this->cartRepository->findOneById($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);

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
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemTextOptionValues($cartId, $cartItemIndex, array $textOptionValues)
    {
        $textOptionIds = array_keys($textOptionValues);
        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds($textOptionIds);

        $cart = $this->cartRepository->findOneById($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);

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
     * @throws EntityNotFoundException
     */
    public function copyCartItems($fromCartId, $toCartId)
    {
        $fromCart = $this->cartRepository->findOneById($fromCartId);
        $toCart = $this->cartRepository->findOneById($toCartId);

        foreach ($fromCart->getCartItems() as $cartItem) {
            $toCart->addCartItem(clone $cartItem);
        }

        $this->cartRepository->save($toCart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param int $quantity
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function updateQuantity($cartId, $cartItemIndex, $quantity)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);
        $cartItem->setQuantity($quantity);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function deleteItem($cartId, $cartItemIndex)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $cart->deleteCartItem($cartItemIndex);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneById($cartId)
    {
        return $this->cartRepository->findOneById($cartId);
    }

    /**
     * @param int $cartId
     * @param ShippingRate $shippingRate
     */
    public function setShippingRate($cartId, ShippingRate $shippingRate)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $cart->setShippingRate($shippingRate);

        $this->cartRepository->save($cart);
    }

    public function setTaxRate($cartId, TaxRate $taxRate = null)
    {
        $cart = $this->cartRepository->findOneById($cartId);
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
        $cart = $this->cartRepository->findOneById($cartId);

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
     * @throws EntityNotFoundException
     */
    public function setUserById($cartId, $userId)
    {
        $user = $this->userRepository->findOneById($userId);
        $cart = $this->cartRepository->findOneById($cartId);

        $cart->setUser($user);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @param int $sessionId
     * @throws EntityNotFoundException
     */
    public function setSessionId($cartId, $sessionId)
    {
        $cart = $this->cartRepository->findOneById($cartId);

        $cart->setSessionId($sessionId);

        $this->cartRepository->save($cart);
    }
}
