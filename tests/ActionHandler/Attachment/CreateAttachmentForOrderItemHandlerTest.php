<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForOrderItemCommand;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttachmentForOrderItemHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        Cart::class,
        Order::class,
        OrderItem::class,
        AbstractPayment::class,
        Shipment::class,
        Product::class,
        Tag::class,
        User::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder();
        $order->setUser($user);
        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $orderItem = $this->dummyData->getOrderItem($order, $product);
        $this->persistEntityAndFlushClear([
            $user,
            $order,
            $product
        ]);
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $command = new CreateAttachmentForOrderItemCommand(
            $uploadFileDTO,
            $orderItem->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $orderItem = $this->getRepositoryFactory()->getOrderItemRepository()->findOneById(
            $orderItem->getId()
        );
        $this->assertNotEmpty($orderItem->getAttachments());
    }
}
