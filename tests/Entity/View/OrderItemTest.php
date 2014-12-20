<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setType('fixed');

        $pricing = new Service\Pricing;
        $pricing->setCatalogPromotions([$catalogPromotion]);
        $cartItem = new Entity\CartItem(new Entity\Product, 1);
        $entityOrderItem = new Entity\OrderItem($cartItem, $pricing);

        $orderItem = $entityOrderItem->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderItem instanceof OrderItem);
        $this->assertTrue($orderItem->product instanceof Product);
        $this->assertTrue($orderItem->catalogPromotions[0] instanceof CatalogPromotion);
    }
}
