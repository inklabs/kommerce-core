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
    public function addCouponByCode(UuidInterface $cartId, string $couponCode): void;

    public function create(
        UuidInterface $cartId,
        string $ip4,
        UuidInterface $userId = null,
        string $sessionId = null
    ): Cart;

    public function addItem(
        UuidInterface $cartItemId,
        UuidInterface $cartId,
        UuidInterface $productId,
        int $quantity = 1
    ): CartItem;

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface[] $optionProductIds
     */
    public function addItemOptionProducts(UuidInterface $cartItemId, array $optionProductIds): void;

    /**
     * @param UuidInterface $cartItemId
     * @param UuidInterface[] $optionValueIds
     */
    public function addItemOptionValues(UuidInterface $cartItemId, array $optionValueIds): void;

    /**
     * @param UuidInterface $cartItemId
     * @param TextOptionValueDTO[] $textOptionValueDTOs
     */
    public function addItemTextOptionValues(UuidInterface $cartItemId, array $textOptionValueDTOs): void;

    public function copyCartItems(UuidInterface $fromCartId, UuidInterface $toCartId): void;

    public function deleteItem(UuidInterface $cartItemId): void;

    public function setExternalShipmentRate(
        UuidInterface $cartId,
        string $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    ): void;
}
