<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
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
    private $attributeService;

    public function setUp()
    {
        parent::setUp();

        $this->attachmentRepository = $this->mockRepository->getAttachmentRepository();
        $this->fileManager = $this->mockService->getFileManager();
        $this->orderService = $this->mockService->getOrderService();

        $this->attributeService = new AttachmentService(
            $this->attachmentRepository,
            $this->fileManager,
            $this->orderService
        );
    }

    public function testCreateAttachmentForOrderItem()
    {
        $orderItem = $this->dummyData->getOrderItem();
        $orderItem->setId(1);

        $uploadFileDTO = $this->dummyData->getUploadFileDTO();

        $this->orderService->shouldReceive('getOrderItemById')
            ->with($orderItem->getId())
            ->andReturn($orderItem)
            ->once();

        $this->fileManager->shouldReceive('saveFile')
            ->with($uploadFileDTO->getFilePath())
            ->once();

        $this->attachmentRepository->shouldReceive('create')
            ->once();

        $this->attributeService->createAttachmentForOrderItem($uploadFileDTO, $orderItem->getId());

        // TODO: Finish testing
    }
}
