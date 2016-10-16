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

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param string $productId
     */
    public function __construct(UploadFileDTO $uploadFileDTO, $productId)
    {
        $this->productId = Uuid::fromString($productId);
        $this->uploadFileDTO = $uploadFileDTO;
    }

    public function getUploadFileDTO()
    {
        return $this->uploadFileDTO;
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
