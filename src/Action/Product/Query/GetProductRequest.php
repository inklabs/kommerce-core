<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductRequest
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
