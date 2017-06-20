<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductsByIdsQuery implements QueryInterface
{
    /** @var UuidInterface[] */
    private $productIds;

    /**
     * @param string[] $productIds
     */
    public function __construct(array $productIds)
    {
        $this->setProductIds($productIds);
    }

    /**
     * @return UuidInterface[]
     */
    public function getProductIds(): array
    {
        return $this->productIds;
    }

    /**
     * @param string[] $productIds
     */
    private function setProductIds(array $productIds)
    {
        $this->productIds = [];

        foreach ($productIds as $productId) {
            $this->productIds[] = Uuid::fromString($productId);
        }
    }
}
