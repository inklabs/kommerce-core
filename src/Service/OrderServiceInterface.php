<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\UuidInterface;

interface OrderServiceInterface
{
    public function update(Order & $order): void;

    public function buyShipmentLabel(
        UuidInterface $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        string $comment,
        string $rateExternalId,
        string $shipmentExternalId
    ): void;

    public function addShipmentTrackingCode(
        UuidInterface $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        string $comment,
        int $shipmentCarrierTypeId,
        string $trackingCode
    ): void;

    public function setOrderStatus(UuidInterface $orderId, OrderStatusType $orderStatusType): void;

    public function addCreditCardPayment(Order $order, CreditCard $creditCard, int $amount): void;

    public function createOrderFromCart(
        UuidInterface $orderId,
        User $user,
        Cart $cart,
        CartCalculatorInterface $cartCalculator,
        string $ip4,
        OrderAddress $shippingAddress,
        OrderAddress $billingAddress,
        CreditCard $creditCard
    ): Order;
}
