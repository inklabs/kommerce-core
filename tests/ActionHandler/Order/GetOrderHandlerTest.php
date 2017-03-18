<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderQuery;
use inklabs\kommerce\Action\Order\Query\GetOrderRequest;
use inklabs\kommerce\ActionResponse\Order\GetOrderResponse;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOrderHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        OrderItem::class,
        Product::class,
        User::class,
        TaxRate::class,
        Cart::class,
        Tag::class,
        Shipment::class,
        AbstractPayment::class,
        Coupon::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder();
        $order->setUser($user);
        $this->persistEntityAndFlushClear([
            $order,
            $user,
        ]);
        $query = new GetOrderQuery($order->getId()->getHex());

        /** @var GetOrderResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertEquals($order->getId(), $response->getOrderDTO()->id);

        $response = $this->dispatchQuery($query);
        $this->assertEquals($order->getId(), $response->getOrderDTOWithAllData()->id);
    }
}
