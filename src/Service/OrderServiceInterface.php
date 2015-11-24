<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\Lib\CartCalculatorInterface;

interface OrderServiceInterface
{
    public function update(Order & $order);

    /**
     * @param int $id
     * @return Order
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

    public function getLatestOrders(Pagination & $pagination = null);

    /**
     * @param int $userId
     * @return Order[]
     */
    public function getOrdersByUserId($userId);

    /**
     * @param int $orderId
     * @param OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param string $rateExternalId
     * @param string $shipmentExternalId
     */
    public function buyShipmentLabel(
        $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $rateExternalId,
        $shipmentExternalId
    );

    /**
     * @param int $orderId
     * @param OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param int $carrier ShipmentTracker::$carrier
     * @param string $trackingCode
     */
    public function addShipmentTrackingCode(
        $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $carrier,
        $trackingCode
    );

    /**
     * @param int $orderId
     * @param int $orderStatus
     * @return mixed
     */
    public function setOrderStatus($orderId, $orderStatus);

    /**
     * @param Order $order
     * @param CreditCard $creditCard
     * @param int $amount
     */
    public function addCreditCardPayment(Order $order, CreditCard $creditCard, $amount);

    /**
     * @param Cart $cart
     * @param CartCalculatorInterface $cartCalculator
     * @param string $ip4
     * @param OrderAddress $shippingAddress
     * @param OrderAddress $billingAddress
     * @param CreditCard $creditCard
     * @return Order
     */
    public function createOrderFromCart(
        Cart $cart,
        CartCalculatorInterface $cartCalculator,
        $ip4,
        OrderAddress $shippingAddress,
        OrderAddress $billingAddress,
        CreditCard $creditCard
    );
}
