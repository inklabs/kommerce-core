<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

class OrderService extends AbstractService implements OrderServiceInterface
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        ProductRepositoryInterface $productRepository,
        ShipmentGatewayInterface $shipmentGateway
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->shipmentGateway = $shipmentGateway;
    }

    public function update(Order & $order)
    {
        $this->throwValidationErrors($order);
        $this->orderRepository->update($order);
    }

    public function findOneById($id)
    {
        $order = $this->orderRepository->findOneById($id);
        $this->loadProductTags($order);
        return $order;
    }

    private function loadProductTags(Order $order)
    {
        $products = $order->getProducts();
        $this->productRepository->loadProductTags($products);
    }

    public function getLatestOrders(Pagination & $pagination = null)
    {
        return $this->orderRepository->getLatestOrders($pagination);
    }

    public function getOrdersByUserId($userId)
    {
        return $this->orderRepository->getOrdersByUserId($userId);
    }

    public function addShipment(
        $orderId,
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

        $shipment = new Shipment;
        $shipment->addShipmentTracker($shipmentTracker);

        if ($comment !== '') {
            $shipment->addShipmentComment(new ShipmentComment($comment));
        }

        foreach ($orderItemQtyDTO->getItems() as $orderItemId => $qty) {
            $orderItem = $this->orderItemRepository->findOneById($orderItemId);

            $shipment->addShipmentItem(
                new ShipmentItem($orderItem, $qty)
            );
        }

        $order->addShipment($shipment);
        $this->update($order);
    }
}
