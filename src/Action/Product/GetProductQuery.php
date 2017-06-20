<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $productId;

    public function __construct(string $productId)
    {
        $this->productId = Uuid::fromString($productId);
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }
}
