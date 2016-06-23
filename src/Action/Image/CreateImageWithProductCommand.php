<?php
namespace inklabs\kommerce\Action\Image;

use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateImageWithProductCommand implements CommandInterface
{
    /** @var ImageDTO */
    private $imageDTO;

    /** @var UuidInterface */
    protected $productId;

    /**
     * @param ImageDTO $imageDTO
     * @param string $productId
     */
    public function __construct($productId, ImageDTO $imageDTO)
    {
        $this->productId = Uuid::fromString($productId);
        $this->imageDTO = $imageDTO;
    }

    public function getImageDTO()
    {
        return $this->imageDTO;
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
