<?php
namespace inklabs\kommerce\Action\Attachment;

use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

class CreateAttachmentForOrderItemCommand implements CommandInterface
{
    /** @var UploadFileDTO */
    private $uploadFileDTO;

    /** @var int */
    private $orderItemId;

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param int $orderItemId 236390
     */
    public function __construct(UploadFileDTO $uploadFileDTO, $orderItemId)
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
