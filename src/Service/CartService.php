<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\InvalidCartActionException;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Event\OrderCreatedFromCartEvent;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use InvalidArgumentException;

class CartService extends AbstractService implements CartServiceInterface
{
    /** @var CartCalculatorInterface */
    protected $cartCalculator;

    /** @var CartRepositoryInterface */
    protected $cartRepository;

    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var OptionProductRepositoryInterface */
    protected $optionProductRepository;

    /** @var OptionValueRepositoryInterface */
    protected $optionValueRepository;

    /** @var OrderRepositoryInterface */
    protected $orderRepository;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var ShipmentGatewayInterface */
    protected $shipmentGateway;

    /** @var TextOptionRepositoryInterface */
    protected $textOptionRepository;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    public function __construct(
        CartCalculatorInterface $cartCalculator,
        CartRepositoryInterface $cartRepository,
        CouponRepositoryInterface $couponRepository,
        EventDispatcherInterface $eventDispatcher,
        OptionProductRepositoryInterface $optionProductRepository,
        OptionValueRepositoryInterface $optionValueRepository,
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        ShipmentGatewayInterface $shipmentGateway,
        TaxRateRepositoryInterface $taxRateRepository,
        TextOptionRepositoryInterface $textOptionRepository,
        UserRepositoryInterface $userRepository,
        InventoryServiceInterface $inventoryService
    ) {
        $this->cartCalculator = $cartCalculator;
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->optionProductRepository = $optionProductRepository;
        $this->optionValueRepository = $optionValueRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->shipmentGateway = $shipmentGateway;
        $this->taxRateRepository = $taxRateRepository;
        $this->textOptionRepository = $textOptionRepository;
        $this->userRepository = $userRepository;
        $this->inventoryService = $inventoryService;
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

        $this->cartRepository->update($cart);

        return $couponIndex;
    }

    public function getCoupons($cartId)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        return $cart->getCoupons();
    }

    public function delete(Cart $cart)
    {
        $this->cartRepository->delete($cart);
    }

    /**
     * @param int $cartId
     */
    public function removeCart($cartId)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $this->cartRepository->delete($cart);
    }

    /**
     * @param int $cartId
     * @param int $couponIndex
     */
    public function removeCoupon($cartId, $couponIndex)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $cart->removeCoupon($couponIndex);

        $this->cartRepository->update($cart);
    }

    /**
     * @param int $userId
     * @param string $sessionId
     * @param string $ip4
     * @return Cart
     */
    public function create($userId, $sessionId, $ip4)
    {
        if (empty($userId) && empty($sessionId)) {
            throw new InvalidArgumentException('User or session id required.');
        }

        $cart = new Cart;
        $cart->setIp4($ip4);
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
        $cart->setShipmentRate(null);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $cartItemIndex = $cart->addCartItem($cartItem);

        $this->cartRepository->update($cart);

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

        $this->cartRepository->update($cart);
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

        $this->cartRepository->update($cart);
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

        $this->cartRepository->update($cart);
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

        $this->cartRepository->update($toCart);
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
        $cart->setShipmentRate(null);

        $cartItem = $cart->getCartItem($cartItemIndex);
        $cartItem->setQuantity($quantity);

        $this->cartRepository->update($cart);
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
        $cart->setShipmentRate(null);
        $cart->deleteCartItem($cartItemIndex);

        $this->cartRepository->update($cart);
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

    public function setTaxRate($cartId, TaxRate $taxRate = null)
    {
        $cart = $this->cartRepository->findOneById($cartId);
        $cart->setTaxRate($taxRate);

        $this->cartRepository->update($cart);
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

        $this->cartRepository->update($cart);
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

        $this->cartRepository->update($cart);
    }

    /**
     * @param int $cartId
     * @param string $shipmentRateExternalId
     * @param OrderAddressDTO $shippingAddressDTO
     */
    public function setShipmentRate(
        $cartId,
        $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    ) {
        $cart = $this->cartRepository->findOneById($cartId);

        $shipmentRate = $this->shipmentGateway->getShipmentRateByExternalId($shipmentRateExternalId);

        $cart->setShipmentRate($shipmentRate);

        $shippingAddress = new OrderAddress;
        $this->setOrderAddressFromDTO($shippingAddress, $shippingAddressDTO);
        $cart->setShippingAddress($shippingAddress);

        $taxRate = $this->taxRateRepository->findByZip5AndState(
            $shippingAddressDTO->zip5,
            $shippingAddressDTO->state
        );

        $cart->setTaxRate($taxRate);

        $this->cartRepository->update($cart);
    }

    private function setOrderAddressFromDTO(OrderAddress & $orderAddress, OrderAddressDTO $orderAddressDTO)
    {
        $orderAddress->firstName = $orderAddressDTO->firstName;
        $orderAddress->lastName = $orderAddressDTO->lastName;
        $orderAddress->company = $orderAddressDTO->company;
        $orderAddress->address1 = $orderAddressDTO->address1;
        $orderAddress->address2 = $orderAddressDTO->address2;
        $orderAddress->city = $orderAddressDTO->city;
        $orderAddress->state = $orderAddressDTO->state;
        $orderAddress->zip5 = $orderAddressDTO->zip5;
        $orderAddress->zip4 = $orderAddressDTO->zip4;
        $orderAddress->phone = $orderAddressDTO->phone;
        $orderAddress->email = $orderAddressDTO->email;
        $orderAddress->setIsResidential($orderAddressDTO->isResidential);
        $orderAddress->setCountry($orderAddressDTO->country);
    }
}
