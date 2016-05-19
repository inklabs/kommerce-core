<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;

class AttachmentService implements AttachmentServiceInterface
{
    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    /** @var FileManagerInterface */
    private $fileManager;

    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(
        AttachmentRepositoryInterface $attachmentRepository,
        FileManagerInterface $fileManager,
        OrderServiceInterface $orderService
    ) {
        $this->attachmentRepository = $attachmentRepository;
        $this->fileManager = $fileManager;
        $this->orderService = $orderService;
    }

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param int $orderItemId
     * @return void
     */
    public function createAttachmentForOrderItem(UploadFileDTO $uploadFileDTO, $orderItemId)
    {
        $orderItem = $this->orderService->getOrderItemById($orderItemId);
        $urlFilePath = $this->fileManager->saveFile($uploadFileDTO->getFilePath());

        $attachment = new Attachment(
            $urlFilePath
        );

        $this->attachmentRepository->create($attachment);

        $order = $orderItem->getOrder();
        $this->orderService->update($order);
    }
}
