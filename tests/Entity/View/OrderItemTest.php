<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setType(Entity\Promotion::TYPE_FIXED);

        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType(Entity\Promotion::TYPE_EXACT);

        $pricing = new Service\Pricing;
        $pricing->setCatalogPromotions([$catalogPromotion]);
        $pricing->setProductQuantityDiscounts([$productQuantityDiscount]);

        $product = new Entity\Product;
        $product->addProductQuantityDiscount($productQuantityDiscount);

        $cartItem = new Entity\CartItem($product, 1);
        $entityOrderItem = new Entity\OrderItem($cartItem, $pricing);

        $order = new Entity\Order(new Entity\Cart, $pricing);
        $entityOrderItem->setOrder($order);

        $orderItem = $entityOrderItem->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderItem instanceof OrderItem);
        $this->assertTrue($orderItem->price instanceof Price);
        $this->assertTrue($orderItem->product instanceof Product);
        $this->assertTrue($orderItem->catalogPromotions[0] instanceof CatalogPromotion);
    }
}
