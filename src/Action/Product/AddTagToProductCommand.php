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

    /**
     * @param string $productId
     * @param string $tagId
     */
    public function __construct($productId, $tagId)
    {
        $this->productId = Uuid::fromString($productId);
        $this->tagId = Uuid::fromString($tagId);
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
