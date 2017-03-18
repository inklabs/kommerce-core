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

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param string $orderItemId
     */
    public function __construct(UploadFileDTO $uploadFileDTO, $orderItemId)
    {
        $this->orderItemId = Uuid::fromString($orderItemId);
        $this->uploadFileDTO = $uploadFileDTO;
    }

    public function getUploadFileDTO()
    {
        return $this->uploadFileDTO;
    }

    public function getOrderItemId()
    {
        return $this->orderItemId;
    }
}
