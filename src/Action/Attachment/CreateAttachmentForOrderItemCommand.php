<?php
namespace inklabs\kommerce\Action\Attachment;

use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

class CreateAttachmentForOrderItemCommand implements CommandInterface
{
    /** @var UploadFileDTO */
    private $uploadFileDTO;

    /** @var UuidInterface */
    private $orderItemId;

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param int $orderItemId 236390
     */
    public function __construct(UploadFileDTO $uploadFileDTO, UuidInterface $orderItemId)
    {
        $this->orderItemId = $orderItemId;
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
