<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Exception\AttachmentException;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class AttachmentServiceTest extends ServiceTestCase
{
    /** @var AttachmentRepositoryInterface | \Mockery\Mock */
    private $attachmentRepository;

    /** @var FileManagerInterface | \Mockery\Mock */
    private $fileManager;

    /** @var OrderServiceInterface | \Mockery\Mock */
    private $orderService;

    /** @var AttachmentService */
    private $attachmentService;

    public function setUp()
    {
        parent::setUp();

        $this->attachmentRepository = $this->mockRepository->getAttachmentRepository();
        $this->fileManager = $this->mockService->getFileManager();
        $this->orderService = $this->mockService->getOrderService();

        $this->attachmentService = new AttachmentService(
            $this->attachmentRepository,
            $this->fileManager,
            $this->orderService
        );
    }

    public function testCreateAttachmentForOrderItem()
    {
        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $orderItem = $this->dummyData->getOrderItem($product);
        $order = $this->dummyData->getOrder();
        $order->addOrderItem($orderItem);

        $uploadFileDTO = $this->dummyData->getUploadFileDTO();

        $this->orderService->shouldReceive('getOrderItemById')
            ->with($orderItem->getId())
            ->andReturn($orderItem)
            ->once();

        $this->fileManager->shouldReceive('saveFile')
            ->with($uploadFileDTO->getFilePath())
            ->andReturn($this->dummyData->getRemoteManagedFile())
            ->once();

        $this->attachmentRepository->shouldReceive('create')
            ->once();

        $this->orderService->shouldReceive('update')
            ->with($order)
            ->once();

        $this->attachmentService->createAttachmentForOrderItem($uploadFileDTO, $orderItem->getId());
    }

    public function testCreateAttachmentForOrderItemReal()
    {
        $this->setupEntityManager([
            AbstractPayment::class,
            Attachment::class,
            Order::class,
            OrderItem::class,
            Product::class,
            Shipment::class,
            Tag::class,
            TaxRate::class,
            User::class,
            Cart::class,
        ]);

        $attachmentService = $this->getServiceFactory()->getAttachmentService();

        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $orderItem = $this->dummyData->getOrderItem($product);
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder(null, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $uploadFileDTO = $this->dummyData->getUploadFileDTO();

        $this->setCountLogger();

        $attachmentService->createAttachmentForOrderItem($uploadFileDTO, $orderItem->getId());

        $this->entityManager->clear();

        $orderRepository = $this->getRepositoryFactory()->getOrderRepository();
        $order = $orderRepository->findOneById($order->getId());

        $this->assertCount(1, $order->getOrderItem(0)->getAttachments());
    }
}
