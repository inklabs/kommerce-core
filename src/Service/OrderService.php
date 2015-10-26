<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

class OrderService extends AbstractService implements OrderServiceInterface
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
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

    /**
     * @param int $orderId
     * @param Shipment $shipment
     */
    public function addShipment($orderId, $shipment)
    {
        $order = $this->orderRepository->findOneById($orderId);
        $order->addShipment($shipment);
        $this->update($order);
    }
}
