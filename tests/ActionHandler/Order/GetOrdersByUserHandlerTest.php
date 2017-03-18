<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrdersByUserQuery;
use inklabs\kommerce\Action\Order\Query\GetOrdersByUserRequest;
use inklabs\kommerce\ActionResponse\Order\GetOrdersByUserResponse;
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

class GetOrdersByUserHandlerTest extends ActionTestCase
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
        $order1 = $this->dummyData->getOrder();
        $order1->setUser($user);
        $order2 = $this->dummyData->getOrder();
        $order2->setUser($user);
        $this->persistEntityAndFlushClear([
            $order1,
            $order2,
            $user,
        ]);
        $query = new GetOrdersByUserQuery($user->getId()->getHex());

        /** @var GetOrdersByUserResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertEntitiesInDTOList([$order1, $order2], $response->getOrderDTOs());

        $response = $this->dispatchQuery($query);
        $this->assertEntitiesInDTOList([$order1, $order2], $response->getOrderDTOsWithAllData());
    }
}
