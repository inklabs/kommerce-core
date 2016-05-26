<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface CartServiceInterface
{
    /**
     * @param string $sessionId
     * @return Cart
     */
    public function findBySession($sessionId);

    /**
     * @param string $userId
     * @return Cart
     */
    public function findByUser($userId);

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
     * @param int $userId
     * @param string $sessionId
     * @param string $ip4
     * @return Cart
     */
    public function create($userId, $sessionId, $ip4);

    /**
     * @param UuidInterface $cartId
     * @param string $productId
     * @param int $quantity
     * @return int $cartItemIndex
     * @throws EntityNotFoundException
     */
    public function addItem(UuidInterface $cartId, $productId, $quantity = 1);

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param string[] $optionProductIds
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionProducts(UuidInterface $cartId, $cartItemIndex, array $optionProductIds);

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param string[] $optionValueIds
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionValues(UuidInterface $cartId, $cartItemIndex, array $optionValueIds);

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param array $textOptionValues
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemTextOptionValues(UuidInterface $cartId, $cartItemIndex, array $textOptionValues);

    /**
     * @param UuidInterface $fromCartId
     * @param UuidInterface $toCartId
     * @throws EntityNotFoundException
     */
    public function copyCartItems(UuidInterface $fromCartId, UuidInterface $toCartId);

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @param int $quantity
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function updateQuantity(UuidInterface $cartId, $cartItemIndex, $quantity);

    /**
     * @param UuidInterface $cartId
     * @param int $cartItemIndex
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function deleteItem(UuidInterface $cartId, $cartItemIndex);

    /**
     * @param UuidInterface $cartId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $cartId);

    public function setTaxRate(UuidInterface $cartId, TaxRate $taxRate = null);

    /**
     * @param UuidInterface $cartId
     * @param int $userId
     * @throws EntityNotFoundException
     */
    public function setUserById(UuidInterface $cartId, $userId);

    /**
     * @param UuidInterface $cartId
     * @param int $sessionId
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
