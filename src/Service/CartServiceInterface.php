<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\Exception\InvalidArgumentException;
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
     * @throws EntityNotFoundException
     */
    public function deleteItem(UuidInterface $cartItemId);

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
}
