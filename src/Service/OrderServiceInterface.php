<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\UuidInterface;

interface OrderServiceInterface
{
    public function update(Order & $order);

    /**
     * @param UuidInterface $id
     * @return Order
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @param UuidInterface $id
     * @return OrderItem
     * @throws EntityNotFoundException
     */
    public function getOrderItemById(UuidInterface $id);

    public function getLatestOrders(Pagination & $pagination = null);

    /**
     * @param UuidInterface $userId
     * @return Order[]
     */
    public function getOrdersByUserId(UuidInterface $userId);

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

    /**
     * @param UuidInterface $orderId
     * @param Cart $cart
     * @param CartCalculatorInterface $cartCalculator
     * @param string $ip4
     * @param OrderAddress $shippingAddress
     * @param OrderAddress $billingAddress
     * @param CreditCard $creditCard
     * @return Order
     */
    public function createOrderFromCart(
        UuidInterface $orderId,
        Cart $cart,
        CartCalculatorInterface $cartCalculator,
        $ip4,
        OrderAddress $shippingAddress,
        OrderAddress $billingAddress,
        CreditCard $creditCard
    );
}
