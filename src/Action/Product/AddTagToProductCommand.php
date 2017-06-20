<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddTagToProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productId;

    /** @var UuidInterface */
    private $tagId;

    public function __construct(string $productId, string $tagId)
    {
        $this->productId = Uuid::fromString($productId);
        $this->tagId = Uuid::fromString($tagId);
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }
}
