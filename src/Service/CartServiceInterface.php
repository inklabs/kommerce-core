<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface CartServiceInterface
{
    /**
     * @param UuidInterface $cartId
     * @param string $couponCode
     * @throws EntityNotFoundException
     */
    public function addCouponByCode(UuidInterface $cartId, $couponCode);

    public function getCoupons(UuidInterface $cartId);

    /**
     * @param UuidInterface $cartId
     */
    public function removeCart(UuidInterface $cartId);

    /**
     * @param UuidInterface $cartId
     * @param UuidInterface $couponId
     */
    public function removeCoupon(UuidInterface $cartId, UuidInterface $couponId);

    /**
     * @param UuidInterface $cartId
     * @param string $ip4
     * @param UuidInterface|null $userId
     * @param string|null $sessionId
     * @return Cart
     * @throws InvalidArgumentException
     */
    public function create(UuidInterface $cartId, $ip4, UuidInterface $userId = null, $sessionId = null);

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface $cartId
     * @param UuidInterface $productId
     * @param int $quantity
     * @return CartItem
     */
    public function addItem(UuidInterface $cartItemId, UuidInterface $cartId, UuidInterface $productId, $quantity = 1);

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface[] $optionProductIds
     * @throws EntityNotFoundException
     */
    public function addItemOptionProducts(UuidInterface $cartItemId, array $optionProductIds);

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface[] $optionValueIds
     * @throws EntityNotFoundException
     */
    public function addItemOptionValues(UuidInterface $cartItemId, array $optionValueIds);

    /**
     * @param UuidInterface $cartItemId
     * @param TextOptionValueDTO[] $textOptionValueDTOs
     * @throws EntityNotFoundException
     */
    public function addItemTextOptionValues(UuidInterface $cartItemId, array $textOptionValueDTOs);

    /**
     * @param UuidInterface $fromCartId
     * @param UuidInterface $toCartId
     * @throws EntityNotFoundException
     */
    public function copyCartItems(UuidInterface $fromCartId, UuidInterface $toCartId);

    /**
     * @param UuidInterface $cartItemId
     * @param int $quantity
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function updateItemQuantity(UuidInterface $cartItemId, $quantity);

    /**
     * @param UuidInterface $cartItemId
     * @throws EntityNotFoundException
     */
    public function deleteItem(UuidInterface $cartItemId);

    public function setTaxRate(UuidInterface $cartId, TaxRate $taxRate = null);

    /**
     * @param UuidInterface $cartId
     * @param UuidInterface $userId
     * @throws EntityNotFoundException
     */
    public function setUserById(UuidInterface $cartId, UuidInterface $userId);

    /**
     * @param UuidInterface $cartId
     * @param string $sessionId
     * @throws EntityNotFoundException
     */
    public function setSessionId(UuidInterface $cartId, $sessionId);

    /**
     * @param UuidInterface $cartId
     * @param string $shipmentRateExternalId
     * @param OrderAddressDTO $shippingAddressDTO
     */
    public function setExternalShipmentRate(
        UuidInterface $cartId,
        $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    );

    /**
     * @param UuidInterface $cartId
     * @param ShipmentRate $shipmentRate
     */
    public function setShipmentRate(UuidInterface $cartId, ShipmentRate $shipmentRate);
}
