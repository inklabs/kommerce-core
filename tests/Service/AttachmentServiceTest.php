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
use inklabs\kommerce\Entity\UserProductAttachment;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
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

    /** @var ProductServiceInterface | \Mockery\Mock */
    private $productService;

    /** @var UserServiceInterface | \Mockery\Mock */
    private $userService;

    /** @var AttachmentService */
    private $attachmentService;

    public function setUp()
    {
        parent::setUp();

        $this->attachmentRepository = $this->mockRepository->getAttachmentRepository();
        $this->fileManager = $this->mockService->getFileManager();
        $this->orderService = $this->mockService->getOrderService();
        $this->productService = $this->mockService->getProductService();
        $this->userService = $this->mockService->getUserService();

        $this->attachmentService = new AttachmentService(
            $this->attachmentRepository,
            $this->fileManager,
            $this->orderService,
            $this->productService,
            $this->userService
        );
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->attachmentService,
            $this->attachmentRepository,
            $this->dummyData->getAttachment()
        );
    }

    public function testCreateAttachmentForOrderItem()
    {
        $order = $this->dummyData->getOrder();

        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $orderItem = $this->dummyData->getOrderItem($order, $product);

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

        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder(null);
        $order->setUser($user);

        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $orderItem = $this->dummyData->getOrderItem($order, $product);

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

    public function testCreateAttachmentForUserProductReal()
    {
        $this->setupEntityManager([
            AbstractPayment::class,
            Attachment::class,
            Cart::class,
            Product::class,
            Tag::class,
            TaxRate::class,
            User::class,
            UserProductAttachment::class,
        ]);

        $attachmentService = $this->getServiceFactory()->getAttachmentService();

        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $user = $this->dummyData->getUser();
        $product = $this->dummyData->getProduct();
        $product->enableAttachments();

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $attachmentService->createAttachmentForUserProduct(
            $uploadFileDTO,
            $user->getId(),
            $product->getId()
        );

        $this->entityManager->clear();
        $attachmentRepository = $this->getRepositoryFactory()->getAttachmentRepository();
        $attachments = $attachmentRepository->getUserProductAttachments(
            $user->getId(),
            $product->getId()
        );

        $this->assertCount(1, $attachments);
    }
}
