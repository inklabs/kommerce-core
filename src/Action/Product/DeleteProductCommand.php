<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productId;

    public function __construct(string $id)
    {
        $this->productId = Uuid::fromString($id);
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }
}
