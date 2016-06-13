<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductRequest
{
    /** @var UuidInterface */
    private $productId;

    /**
     * @param string $productIdString
     */
    public function __construct($productIdString)
    {
        $this->productId = Uuid::fromString($productIdString);
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
