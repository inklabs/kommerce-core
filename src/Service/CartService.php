<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use Ramsey\Uuid\UuidInterface;

class CartService implements CartServiceInterface
{
    use EntityValidationTrait;

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
     * @param UuidInterface $userId
     * @return Cart
     */
    public function findByUser(UuidInterface $userId)
    {
        return $this->cartRepository->findOneByUserId($userId);
    }

    /**
     * @param UuidInterface $cartId
     * @param string $couponCode
     * @return int
     * @throws EntityNotFoundException
     */
    public function addCouponByCode(UuidInterface $cartId, $couponCode)
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);
        $cart = $this->cartRepository->findOneByUuId($cartId);

        $couponIndex = $cart->addCoupon($coupon);

        $this->cartRepository->update($cart);

        return $couponIndex;
    }

    public function getCoupons(UuidInterface $cartId)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        return $cart->getCoupons();
    }

    public function delete(Cart $cart)
    {
        $this->cartRepository->delete($cart);
    }

    public function removeCart(UuidInterface $cartId)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $this->cartRepository->delete($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param int $couponIndex
     */
    public function removeCoupon(UuidInterface $cartId, $couponIndex)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cart->removeCoupon($couponIndex);

        $this->cartRepository->update($cart);
    }

    /**
     * @param string $ip4
     * @param UuidInterface | null $userId
     * @param string | null $sessionId
     * @return Cart
     * @throws InvalidArgumentException
     */
    public function create($ip4, UuidInterface $userId = null, $sessionId = null)
    {
        if (empty($userId) && empty($sessionId)) {
            throw new InvalidArgumentException('User or session id required.');
        }

        $cart = new Cart;
        $cart->setIp4($ip4);
        $cart->setSessionId($sessionId);
        $cart->setUpdated();

        $this->addUserToCartIfExists($cart, $userId);

        $this->cartRepository->create($cart);

        return $cart;
    }

    private function addUserToCartIfExists(Cart & $cart, UuidInterface $userId = null)
    {
        if (! empty($userId)) {
            $user = $this->userRepository->findOneById($userId);
            $cart->setUser($user);
        }
    }

    /**
     * @param UuidInterface $cartId
     * @param UuidInterface $productId
     * @param int $quantity
     * @return int $cartItemIndex
     * @throws EntityNotFoundException
     */
    public function addItem(UuidInterface $cartId, UuidInterface $productId, $quantity = 1)
    {
        $product = $this->productRepository->findOneById($productId);
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cart->setShipmentRate(null);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $cartItemIndex = $cart->addCartItem($cartItem);

        $this->cartRepository->update($cart);

        return $cartItemIndex;
    }

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param string[] $optionProductIds
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionProducts(UuidInterface $cartId, $cartItemIndex, array $optionProductIds)
    {
        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds($optionProductIds);

        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);

        foreach ($optionProducts as $optionProduct) {
            $cartItemOptionProduct = new CartItemOptionProduct;
            $cartItemOptionProduct->setOptionProduct($optionProduct);

            $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        }

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param string[] $optionValueIds
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionValues(UuidInterface $cartId, $cartItemIndex, array $optionValueIds)
    {
        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds($optionValueIds);

        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);

        foreach ($optionValues as $optionValue) {
            $cartItemOptionValue = new CartItemOptionValue;
            $cartItemOptionValue->setOptionValue($optionValue);

            $cartItem->addCartItemOptionValue($cartItemOptionValue);
        }

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param array $textOptionValues
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemTextOptionValues(UuidInterface $cartId, $cartItemIndex, array $textOptionValues)
    {
        $textOptionIds = array_keys($textOptionValues);
        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds($textOptionIds);

        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cartItem = $cart->getCartItem($cartItemIndex);

        foreach ($textOptions as $textOption) {
            $textOptionValue = $textOptionValues[$textOption->getId()->getHex()];

            $cartItemTextOptionValue = new CartItemTextOptionValue;
            $cartItemTextOptionValue->setTextOption($textOption);
            $cartItemTextOptionValue->setTextOptionValue($textOptionValue);

            $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);
        }

        $this->cartRepository->update($cart);
    }

    public function copyCartItems(UuidInterface $fromCartId, UuidInterface $toCartId)
    {
        $fromCart = $this->cartRepository->findOneByUuid($fromCartId);
        $toCart = $this->cartRepository->findOneByUuid($toCartId);

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
    public function updateQuantity(UuidInterface $cartId, $cartItemIndex, $quantity)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cart->setShipmentRate(null);

        $cartItem = $cart->getCartItem($cartItemIndex);
        $cartItem->setQuantity($quantity);

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function deleteItem(UuidInterface $cartId, $cartItemIndex)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cart->setShipmentRate(null);
        $cart->deleteCartItem($cartItemIndex);

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $cartId)
    {
        return $this->cartRepository->findOneByUuid($cartId);
    }

    public function setTaxRate(UuidInterface $cartId, TaxRate $taxRate = null)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cart->setTaxRate($taxRate);

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param UuidInterface $userId
     * @throws EntityNotFoundException
     */
    public function setUserById(UuidInterface $cartId, UuidInterface $userId)
    {
        $user = $this->userRepository->findOneById($userId);
        $cart = $this->cartRepository->findOneByUuid($cartId);

        $cart->setUser($user);

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param int $sessionId
     * @throws EntityNotFoundException
     */
    public function setSessionId(UuidInterface $cartId, $sessionId)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);

        $cart->setSessionId($sessionId);

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param string $shipmentRateExternalId
     * @param OrderAddressDTO $shippingAddressDTO
     */
    public function setExternalShipmentRate(
        UuidInterface $cartId,
        $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    ) {
        $cart = $this->cartRepository->findOneByUuid($cartId);

        $shipmentRate = $this->shipmentGateway->getShipmentRateByExternalId($shipmentRateExternalId);

        $cart->setShipmentRate($shipmentRate);

        $shippingAddress = OrderAddressDTOBuilder::createFromDTO($shippingAddressDTO);
        $cart->setShippingAddress($shippingAddress);

        $taxRate = $this->taxRateRepository->findByZip5AndState(
            $shippingAddressDTO->zip5,
            $shippingAddressDTO->state
        );

        $cart->setTaxRate($taxRate);

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartId
     * @param ShipmentRate $shipmentRate
     */
    public function setShipmentRate(UuidInterface $cartId, ShipmentRate $shipmentRate)
    {
        $cart = $this->cartRepository->findOneByUuid($cartId);
        $cart->setShipmentRate($shipmentRate);
        $this->cartRepository->update($cart);
    }
}
