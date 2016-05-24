<?php
namespace inklabs\kommerce\ActionHandler\Migrate;

use inklabs\kommerce\Action\Migrate\MigrateOrdersToUUIDCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MigrateOrdersToUUIDHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $this->setupEntityManager();
        $this->setupOrder();

        $command = new MigrateOrdersToUUIDCommand();
        $handler = new MigrateOrdersToUUIDHandler($this->entityManager);

        $this->setCountLogger(true);
        $handler->handle($command);
    }

    private function setupOrder($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $product = $this->dummyData->getProduct($uniqueId);
        $price = $this->dummyData->getPrice();
        $user = $this->dummyData->getUser($uniqueId);
        $orderItem = $this->dummyData->getOrderItem($product, $price);
        $cartTotal = $this->dummyData->getCartTotal();
        $taxRate = $this->dummyData->getTaxRate();
        $shipmentItem = $this->dummyData->getShipmentItem($orderItem, 1);
        $shipment = $this->dummyData->getShipment($shipmentItem);

        $order = $this->dummyData->getOrder($cartTotal, [$orderItem]);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);
        $order->addShipment($shipment);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);
        $this->entityManager->persist($order);

        $this->entityManager->flush();

        return $order;
    }
}
