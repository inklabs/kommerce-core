<?php
namespace inklabs\kommerce\Action\Attachment;

use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateAttachmentForUserProductCommand implements CommandInterface
{
    /** @var UploadFileDTO */
    private $uploadFileDTO;

    /** @var UuidInterface */
    private $userId;

    /** @var UuidInterface */
    private $productId;

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param string $userId
     * @param string $productId
     */
    public function __construct(UploadFileDTO $uploadFileDTO, $userId, $productId)
    {
        $this->userId = Uuid::fromString($userId);
        $this->productId = Uuid::fromString($productId);
        $this->uploadFileDTO = $uploadFileDTO;
    }

    public function getUploadFileDTO()
    {
        return $this->uploadFileDTO;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
