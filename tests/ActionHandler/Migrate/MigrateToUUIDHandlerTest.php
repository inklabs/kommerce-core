<?php
namespace inklabs\kommerce\ActionHandler\Migrate;

use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MigrateToUUIDHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $this->setupEntityManager();
        $this->setupDB();

        $handler = new MigrateToUUIDHandler($this->entityManager);

//        $this->setCountLogger(true);
        $handler->handle();
    }

    private function setupDB($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $tag = $this->dummyData->getTag();
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotion->setTag($tag);

        $product = $this->dummyData->getProduct($uniqueId);
        $price = $this->dummyData->getPrice();

        $userLogin = $this->dummyData->getUserLogin();
        $user = $this->dummyData->getUser($uniqueId);
        $user->addUserLogin($userLogin);

        $orderItem1 = $this->dummyData->getOrderItem($product, $price);
        $orderItem1->addCatalogPromotion($catalogPromotion);

        $orderItem2 = $this->dummyData->getOrderItem($product, $price);

        $cartTotal = $this->dummyData->getCartTotal();
        $taxRate = $this->dummyData->getTaxRate();
        $shipment = $this->dummyData->getShipment();
        $shipmentItem = $this->dummyData->getShipmentItem($shipment, $orderItem1, 1);

        $order = $this->dummyData->getOrder($cartTotal, [$orderItem1, $orderItem2]);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);
        $order->addShipment($shipment);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);
        $this->entityManager->persist($order);

        $this->entityManager->flush();

        return $order;
    }
}
