<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface AttachmentServiceInterface
{
    public function update(Attachment & $attachment);
    public function delete(Attachment $attachment);

    /**
     * @param UuidInterface $attachmentId
     * @return Attachment
     * @throws EntityNotFoundException
     */
    public function getOneById(UuidInterface $attachmentId);

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param UuidInterface $orderItemId
     * @return void
     */
    public function createAttachmentForOrderItem(UploadFileDTO $uploadFileDTO, UuidInterface $orderItemId);

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param UuidInterface $userId
     * @param UuidInterface $productId
     * @return void
     */
    public function createAttachmentForUserProduct(
        UploadFileDTO $uploadFileDTO,
        UuidInterface $userId,
        UuidInterface $productId
    );
}
