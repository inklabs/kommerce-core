<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $productId;

    /**
     * @param string $productId
     */
    public function __construct($productId)
    {
        $this->productId = Uuid::fromString($productId);
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
