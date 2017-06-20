<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentCarrierType;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Event\OrderCreatedFromCartEvent;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberGeneratorInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

class OrderService implements OrderServiceInterface
{
    use EntityValidationTrait;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var InventoryServiceInterface */
    private $inventoryService;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var PaymentGatewayInterface */
    protected $paymentGateway;

    /** @var ReferenceNumberGeneratorInterface */
    private $referenceNumberGenerator;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        InventoryServiceInterface $inventoryService,
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        PaymentGatewayInterface $paymentGateway,
        ProductRepositoryInterface $productRepository,
        ShipmentGatewayInterface $shipmentGateway,
        ReferenceNumberGeneratorInterface $referenceNumberGenerator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->inventoryService = $inventoryService;
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->paymentGateway = $paymentGateway;
        $this->shipmentGateway = $shipmentGateway;
        $this->referenceNumberGenerator = $referenceNumberGenerator;
    }

    public function update(Order & $order)
    {
        $this->orderRepository->update($order);
        $this->eventDispatcher->dispatchEvents($order->releaseEvents());
    }

    public function buyShipmentLabel(
        UuidInterface $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $rateExternalId,
        $shipmentExternalId
    ) {
        $order = $this->orderRepository->findOneById($orderId);

        $shipmentTracker = $this->shipmentGateway->buy(
            $shipmentExternalId,
            $rateExternalId
        );

        $this->addShipment($comment, $orderItemQtyDTO, $shipmentTracker, $order);
    }

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
    ) {
        $order = $this->orderRepository->findOneById($orderId);

        $shipmentCarrierType = ShipmentCarrierType::createById($shipmentCarrierTypeId);
        $shipmentTracker = new ShipmentTracker($shipmentCarrierType, $trackingCode);

        $this->addShipment($comment, $orderItemQtyDTO, $shipmentTracker, $order);
    }

    /**
     * @param string $comment
     * @param \inklabs\kommerce\EntityDTO\OrderItemQtyDTO $orderItemQtyDTO
     * @param ShipmentTracker $shipmentTracker
     * @param Order $order
     */
    private function addShipment(
        $comment,
        OrderItemQtyDTO $orderItemQtyDTO,
        ShipmentTracker $shipmentTracker,
        Order $order
    ) {
        $shipment = new Shipment;

        $shipmentTracker->setShipment($shipment);

        if ($comment !== '') {
            new ShipmentComment($shipment, $comment);
        }

        $this->addShipmentItemsFromOrderItems($orderItemQtyDTO, $shipment);
        $this->shipProductsFromInventory($order, $orderItemQtyDTO);

        $order->addShipment($shipment);
        $this->update($order);
    }

    private function addShipmentItemsFromOrderItems(OrderItemQtyDTO $orderItemQtyDTO, Shipment $shipment)
    {
        foreach ($orderItemQtyDTO->getItems() as $orderItemId => $quantity) {
            $orderItem = $this->orderItemRepository->findOneById(Uuid::fromString($orderItemId));

            new ShipmentItem($shipment, $orderItem, $quantity);
        }
    }

    /**
     * @param UuidInterface $orderId
     * @param OrderStatusType $orderStatusType
     */
    public function setOrderStatus(UuidInterface $orderId, OrderStatusType $orderStatusType)
    {
        $order = $this->orderRepository->findOneById($orderId);
        $order->setStatus($orderStatusType);
        $this->update($order);

        if ($orderStatusType->isFinished()) {
            $this->lockOrderAttachments($order);
        }
    }

    private function lockOrderAttachments(Order $order)
    {
        foreach ($order->getOrderItems() as $orderItem) {
            $this->lockOrderItemAttachments($orderItem);
        }
    }

    private function lockOrderItemAttachments(OrderItem $orderItem)
    {
        foreach ($orderItem->getAttachments() as $attachment) {
            $this->lockAttachment($attachment);
        }
    }

    private function lockAttachment(Attachment $attachment)
    {
        if (! $attachment->isLocked()) {
            $attachment->setLocked();
            $this->updateAttachment($attachment);
        }
    }

    private function updateAttachment(Attachment & $attachment)
    {
        // TODO: Move this responsibility to the Attachment Service without a cyclic dependency
        $this->orderRepository->update($attachment);
    }

    public function createOrderFromCart(
        UuidInterface $orderId,
        User $user,
        Cart $cart,
        CartCalculatorInterface $cartCalculator,
        string $ip4,
        OrderAddress $shippingAddress,
        OrderAddress $billingAddress,
        CreditCard $creditCard
    ): Order {
        $this->throwValidationErrors($creditCard);

        $order = Order::fromCart($orderId, $user, $cart, $cartCalculator, $ip4);
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);

        $this->throwValidationErrors($order);

        $order->setReferenceNumber(
            $this->referenceNumberGenerator->generate()
        );

        $this->reserveProductsFromInventory($order);
        $this->addCreditCardPayment($order, $creditCard, $order->getTotal()->total);

        $this->orderRepository->create($order);

        $this->eventDispatcher->dispatchEvent(
            new OrderCreatedFromCartEvent($order->getId())
        );

        return $order;
    }

    /**
     * @param Order $order
     * @param CreditCard $creditCard
     * @param int $amount
     */
    public function addCreditCardPayment(Order $order, CreditCard $creditCard, $amount)
    {
        $chargeRequest = new ChargeRequest;
        $chargeRequest->setCreditCard($creditCard);
        $chargeRequest->setAmount($amount);
        $chargeRequest->setCurrency('usd');
        $chargeRequest->setDescription($order->getShippingAddress()->getEmail());

        $chargeResponse = $this->paymentGateway->getCharge($chargeRequest);

        $payment = new CreditPayment($chargeResponse);

        $this->throwValidationErrors($payment);
        $order->addPayment($payment);
    }

    private function reserveProductsFromInventory(Order $order)
    {
        foreach ($order->getOrderItems() as $orderItem) {
            $this->inventoryService->reserveProductForOrder(
                $order,
                $orderItem->getProduct(),
                $orderItem->getQuantity()
            );

            $this->reduceProductInventory(
                $orderItem->getProduct(),
                $orderItem->getQuantity()
            );

            foreach ($orderItem->getOrderItemOptionProducts() as $orderItemOptionProduct) {
                $this->inventoryService->reserveProductForOrder(
                    $order,
                    $orderItemOptionProduct->getOptionProduct()->getProduct(),
                    $orderItem->getQuantity()
                );

                $this->reduceProductInventory(
                    $orderItemOptionProduct->getOptionProduct()->getProduct(),
                    $orderItem->getQuantity()
                );
            }
        }
    }

    private function shipProductsFromInventory(Order $order, OrderItemQtyDTO $orderItemQtyDTO)
    {
        foreach ($order->getOrderItems() as $orderItem) {
            $quantity = $orderItemQtyDTO->getItemQuantity($orderItem->getId());
            if ($quantity !== null) {
                $this->inventoryService->shipProductForOrderItem(
                    $orderItem,
                    $orderItem->getProduct(),
                    $quantity
                );

                $this->reduceProductInventory(
                    $orderItem->getProduct(),
                    $quantity
                );

                foreach ($orderItem->getOrderItemOptionProducts() as $orderItemOptionProduct) {
                    $this->inventoryService->shipProductForOrderItem(
                        $orderItem,
                        $orderItemOptionProduct->getOptionProduct()->getProduct(),
                        $quantity
                    );

                    $this->reduceProductInventory(
                        $orderItemOptionProduct->getOptionProduct()->getProduct(),
                        $quantity
                    );
                }
            }
        }
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    private function reduceProductInventory(Product $product, $quantity)
    {
        $product->reduceQuantity($quantity);
        $this->productRepository->update($product);
    }
}
