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
    public function update(Order & $order);

    /**
     * @param UuidInterface $orderId
     * @param \inklabs\kommerce\EntityDTO\OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param string $rateExternalId
     * @param string $shipmentExternalId
     */
    public function buyShipmentLabel(
        UuidInterface $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $rateExternalId,
        $shipmentExternalId
    );

    /**
     * @param UuidInterface $orderId
     * @param \inklabs\kommerce\EntityDTO\OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param int $shipmentCarrierTypeId
     * @param string $trackingCode
     */
    public function addShipmentTrackingCode(
        UuidInterface $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $shipmentCarrierTypeId,
        $trackingCode
    );

    public function setOrderStatus(UuidInterface $orderId, OrderStatusType $orderStatusType);

    /**
     * @param Order $order
     * @param CreditCard $creditCard
     * @param int $amount
     */
    public function addCreditCardPayment(Order $order, CreditCard $creditCard, $amount);

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
