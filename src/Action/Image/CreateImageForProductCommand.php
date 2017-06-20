<?php
namespace inklabs\kommerce\Action\Image;

use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateImageForProductCommand implements CommandInterface
{
    /** @var UploadFileDTO */
    private $uploadFileDTO;

    /** @var UuidInterface */
    protected $productId;

    public function __construct(UploadFileDTO $uploadFileDTO, string $productId)
    {
        $this->productId = Uuid::fromString($productId);
        $this->uploadFileDTO = $uploadFileDTO;
    }

    public function getUploadFileDTO(): UploadFileDTO
    {
        return $this->uploadFileDTO;
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }
}
