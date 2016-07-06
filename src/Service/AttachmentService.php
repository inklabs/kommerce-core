<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\UuidInterface;

class AttachmentService implements AttachmentServiceInterface
{
    use EntityValidationTrait;

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

    public function create(Attachment & $attachment)
    {
        $this->throwValidationErrors($attachment);
        $this->attachmentRepository->create($attachment);
    }

    public function update(Attachment & $attachment)
    {
        $this->throwValidationErrors($attachment);
        $this->attachmentRepository->update($attachment);
    }

    public function delete(Attachment $attachment)
    {
        $this->attachmentRepository->delete($attachment);
    }

    /**
     * @param UuidInterface $attachmentId
     * @return Attachment
     * @throws EntityNotFoundException
     */
    public function getOneById(UuidInterface $attachmentId)
    {
        return $this->attachmentRepository->findOneById($attachmentId);
    }

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param UuidInterface $orderItemId
     * @return void
     */
    public function createAttachmentForOrderItem(UploadFileDTO $uploadFileDTO, UuidInterface $orderItemId)
    {
        $orderItem = $this->orderService->getOrderItemById($orderItemId);
        $order = $orderItem->getOrder();

        $managedFile = $this->fileManager->saveFile($uploadFileDTO->getFilePath());

        $attachment = new Attachment(
            $managedFile->getUri()
        );

        $this->attachmentRepository->create($attachment);

        $orderItem->addAttachment($attachment);
        $this->orderService->update($order);
    }
}
