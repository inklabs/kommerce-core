<?php
namespace inklabs\kommerce\Service;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityDTO\Builder\OrderAddressDTOBuilder;
use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Exception\InvalidArgumentException;
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
use inklabs\kommerce\Lib\UuidInterface;

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

    public function addCouponByCode(UuidInterface $cartId, string $couponCode): void
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);
        $cart = $this->cartRepository->findOneById($cartId);

        $cart->addCoupon($coupon);

        $this->cartRepository->update($cart);
    }

    public function create(
        UuidInterface $cartId,
        string $ip4,
        UuidInterface $userId = null,
        string $sessionId = null
    ): Cart {
        if (empty($userId) && empty($sessionId)) {
            throw new InvalidArgumentException('User or session id required.');
        }

        $cart = new Cart($cartId);
        $cart->setIp4($ip4);
        $cart->setSessionId($sessionId);
        $cart->setUpdated();

        $this->addUserToCartIfExists($cart, $userId);

        $this->cartRepository->create($cart);

        return $cart;
    }

    private function addUserToCartIfExists(Cart & $cart, UuidInterface $userId = null): void
    {
        if (! empty($userId)) {
            $user = $this->userRepository->findOneById($userId);
            $cart->setUser($user);
        }
    }

    public function addItem(
        UuidInterface $cartItemId,
        UuidInterface $cartId,
        UuidInterface $productId,
        int $quantity = 1
    ): CartItem {
        $product = $this->productRepository->findOneById($productId);
        $cart = $this->cartRepository->findOneById($cartId);
        $cart->setShipmentRate(null);

        $cartItem = new CartItem($cart, $cartItemId);
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        $this->cartRepository->update($cart);

        return $cartItem;
    }

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface[] $optionProductIds
     */
    public function addItemOptionProducts(UuidInterface $cartItemId, array $optionProductIds): void
    {
        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds($optionProductIds);

        $cartItem = $this->cartRepository->getItemById($cartItemId);
        $cart = $cartItem->getCart();

        foreach ($optionProducts as $optionProduct) {
            $cartItemOptionProduct = new CartItemOptionProduct;
            $cartItemOptionProduct->setOptionProduct($optionProduct);

            $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        }

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface[] $optionValueIds
     */
    public function addItemOptionValues(UuidInterface $cartItemId, array $optionValueIds): void
    {
        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds($optionValueIds);

        $cartItem = $this->cartRepository->getItemById($cartItemId);
        $cart = $cartItem->getCart();

        foreach ($optionValues as $optionValue) {
            $cartItemOptionValue = new CartItemOptionValue;
            $cartItemOptionValue->setOptionValue($optionValue);

            $cartItem->addCartItemOptionValue($cartItemOptionValue);
        }

        $this->cartRepository->update($cart);
    }

    /**
     * @param UuidInterface $cartItemId
     * @param TextOptionValueDTO[] $textOptionValueDTOs
     */
    public function addItemTextOptionValues(UuidInterface $cartItemId, array $textOptionValueDTOs): void
    {
        $textOptionCollection = $this->getTextOptionsCollection($textOptionValueDTOs);

        $cartItem = $this->cartRepository->getItemById($cartItemId);
        $cart = $cartItem->getCart();

        foreach ($textOptionValueDTOs as $textOptionValueDTO) {
            $textOption = $textOptionCollection->get($textOptionValueDTO->getTextOptionId()->getHex());

            $cartItemTextOptionValue = new CartItemTextOptionValue($textOptionValueDTO->getTextOptionValue());
            $cartItemTextOptionValue->setTextOption($textOption);

            $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);
        }

        $this->cartRepository->update($cart);
    }

    /**
     * @param TextOptionValueDTO[] $textOptionValueDTOs
     * @return ArrayCollection|TextOption[]
     */
    private function getTextOptionsCollection(array $textOptionValueDTOs)
    {
        $textOptionIds = [];
        foreach ($textOptionValueDTOs as $textOptionValueDTO) {
            $textOptionIds[] = $textOptionValueDTO->getTextOptionId();
        }

        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds($textOptionIds);

        $textOptionCollection = new ArrayCollection();
        foreach ($textOptions as $textOption) {
            $textOptionCollection->set($textOption->getId()->getHex(), $textOption);
        }

        return $textOptionCollection;
    }

    public function copyCartItems(UuidInterface $fromCartId, UuidInterface $toCartId): void
    {
        $fromCart = $this->cartRepository->findOneById($fromCartId);
        $toCart = $this->cartRepository->findOneById($toCartId);

        foreach ($fromCart->getCartItems() as $cartItem) {
            $newCartItem = clone $cartItem;
            $newCartItem->setCart($toCart);
        }

        $this->cartRepository->update($toCart);
    }

    public function deleteItem(UuidInterface $cartItemId): void
    {
        $cartItem = $this->cartRepository->getItemById($cartItemId);
        $cart = $cartItem->getCart();
        $cart->setShipmentRate(null);
        $cart->deleteCartItem($cartItem);

        $this->cartRepository->update($cart);
    }

    public function setExternalShipmentRate(
        UuidInterface $cartId,
        string $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    ): void {
        $cart = $this->cartRepository->findOneById($cartId);

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
}
