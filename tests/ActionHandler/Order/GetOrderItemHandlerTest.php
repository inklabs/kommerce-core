<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderItemQuery;
use inklabs\kommerce\Action\Order\Query\GetOrderItemRequest;
use inklabs\kommerce\Action\Order\Query\GetOrderItemResponse;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrderItemHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        OrderItemOptionValue::class,
        OrderItemTextOptionValue::class,
        Product::class,
        ProductQuantityDiscount::class,
        OptionProduct::class,
        OptionValue::class,
        User::class,
        CatalogPromotion::class,
        Cart::class,
        Tag::class,
        TextOption::class,
        Shipment::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder();
        $product = $this->dummyData->getProduct();
        $orderItem = $this->dummyData->getOrderItem($order, $product);
        $order->setUser($user);
        $this->persistEntityAndFlushClear([
            $order,
            $orderItem,
            $product,
            $user,
        ]);
        $request = new GetOrderItemRequest($orderItem->getId()->getHex());
        $response = new GetOrderItemResponse;
        $query = new GetOrderItemQuery($request, $response);

        $this->dispatchQuery($query);
        $this->assertEquals($orderItem->getId(), $response->getOrderItemDTO()->id);

        $this->dispatchQuery($query);
        $this->assertEquals($orderItem->getId(), $response->getOrderItemDTOWithAllData()->id);
    }
}
