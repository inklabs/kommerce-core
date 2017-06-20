<?php
namespace inklabs\kommerce\Action\Attachment;

use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateAttachmentForOrderItemCommand implements CommandInterface
{
    /** @var UploadFileDTO */
    private $uploadFileDTO;

    /** @var UuidInterface */
    private $orderItemId;

    public function __construct(UploadFileDTO $uploadFileDTO, string $orderItemId)
    {
        $this->orderItemId = Uuid::fromString($orderItemId);
        $this->uploadFileDTO = $uploadFileDTO;
    }

    public function getUploadFileDTO(): UploadFileDTO
    {
        return $this->uploadFileDTO;
    }

    public function getOrderItemId(): UuidInterface
    {
        return $this->orderItemId;
    }
}
