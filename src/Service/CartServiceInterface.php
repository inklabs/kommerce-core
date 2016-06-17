<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface CartServiceInterface
{
    /**
     * @param string $sessionId
     * @return Cart
     */
    public function findBySession($sessionId);

    /**
     * @param UuidInterface $userId
     * @return Cart
     */
    public function findByUser(UuidInterface $userId);

    /**
     * @param UuidInterface $cartId
     * @param string $couponCode
     * @return int
     * @throws EntityNotFoundException
     */
    public function addCouponByCode(UuidInterface $cartId, $couponCode);

    public function getCoupons(UuidInterface $cartId);

    public function delete(Cart $cart);

    /**
     * @param UuidInterface $cartId
     */
    public function removeCart(UuidInterface $cartId);

    /**
     * @param UuidInterface $cartId
     * @param int $couponIndex
     */
    public function removeCoupon(UuidInterface $cartId, $couponIndex);

    /**
     * @param string $ip4
     * @param UuidInterface $userId
     * @param string $sessionId
     * @return Cart
     */
    public function create($ip4, UuidInterface $userId, $sessionId);

    /**
     * @param UuidInterface $cartId
     * @param UuidInterface $productId
     * @param int $quantity
     * @return CartItem
     * @throws EntityNotFoundException
     */
    public function addItem(UuidInterface $cartId, UuidInterface $productId, $quantity = 1);

    /**
     * @param UuidInterface $cartItemId
     * @param string[] $optionProductIds
     * @throws EntityNotFoundException
     */
    public function addItemOptionProducts(UuidInterface $cartItemId, array $optionProductIds);

    /**
     * @param UuidInterface $cartItemId
     * @param string[] $optionValueIds
     * @throws EntityNotFoundException
     */
    public function addItemOptionValues(UuidInterface $cartItemId, array $optionValueIds);

    /**
     * @param UuidInterface $cartItemId
     * @param array $textOptionValues
     * @throws EntityNotFoundException
     */
    public function addItemTextOptionValues(UuidInterface $cartItemId, array $textOptionValues);

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

    /**
     * @param UuidInterface $cartId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $cartId);

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
