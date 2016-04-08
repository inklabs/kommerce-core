<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;

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
     * @param int $cartId
     * @param string $couponCode
     * @return int
     * @throws EntityNotFoundException
     */
    public function addCouponByCode($cartId, $couponCode);

    public function getCoupons($cartId);

    public function delete(Cart $cart);

    /**
     * @param int $cartId
     */
    public function removeCart($cartId);

    /**
     * @param int $cartId
     * @param int $couponIndex
     */
    public function removeCoupon($cartId, $couponIndex);

    /**
     * @param int $userId
     * @param string $sessionId
     * @param string $ip4
     * @return Cart
     */
    public function create($userId, $sessionId, $ip4);

    /**
     * @param int $cartId
     * @param string $productId
     * @param int $quantity
     * @return int $cartItemIndex
     * @throws EntityNotFoundException
     */
    public function addItem($cartId, $productId, $quantity = 1);

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param string[] $optionProductIds
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionProducts($cartId, $cartItemIndex, array $optionProductIds);

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param string[] $optionValueIds
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemOptionValues($cartId, $cartItemIndex, array $optionValueIds);

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param array $textOptionValues
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function addItemTextOptionValues($cartId, $cartItemIndex, array $textOptionValues);

    /**
     * @param int $fromCartId
     * @param int $toCartId
     * @throws EntityNotFoundException
     */
    public function copyCartItems($fromCartId, $toCartId);

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @param int $quantity
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function updateQuantity($cartId, $cartItemIndex, $quantity);

    /**
     * @param int $cartId
     * @param int $cartItemIndex
     * @throws EntityNotFoundException
     * @throws InvalidCartActionException
     */
    public function deleteItem($cartId, $cartItemIndex);

    /**
     * @param int $cartId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneById($cartId);

    public function setTaxRate($cartId, TaxRate $taxRate = null);

    /**
     * @param int $cartId
     * @param int $userId
     * @throws EntityNotFoundException
     */
    public function setUserById($cartId, $userId);

    /**
     * @param int $cartId
     * @param int $sessionId
     * @throws EntityNotFoundException
     */
    public function setSessionId($cartId, $sessionId);

    /**
     * @param int $cartId
     * @param string $shipmentRateExternalId
     * @param OrderAddressDTO $shippingAddressDTO
     */
    public function setShipmentRate(
        $cartId,
        $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    );
}
