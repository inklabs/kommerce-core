<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class RemoveImageFromProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productId;

    /** @var UuidInterface */
    private $imageId;

    /**
     * @param string $productId
     * @param string $imageId
     */
    public function __construct($productId, $imageId)
    {
        $this->productId = Uuid::fromString($productId);
        $this->imageId = Uuid::fromString($imageId);
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getImageId()
    {
        return $this->imageId;
    }
}
