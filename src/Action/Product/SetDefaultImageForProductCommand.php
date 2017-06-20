<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetDefaultImageForProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productId;

    /** @var UuidInterface */
    private $imageId;

    public function __construct(string $productId, string $imageId)
    {
        $this->productId = Uuid::fromString($productId);
        $this->imageId = Uuid::fromString($imageId);
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    public function getImageId(): UuidInterface
    {
        return $this->imageId;
    }
}
