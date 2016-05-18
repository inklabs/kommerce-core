<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityDTO\UploadFileDTO;

interface AttachmentServiceInterface
{
    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param int $orderItemId
     * @return void
     */
    public function createAttachmentForOrderItem(UploadFileDTO $uploadFileDTO, $orderItemId);
}
