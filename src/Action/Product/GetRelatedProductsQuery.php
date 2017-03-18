<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetRelatedProductsQuery implements QueryInterface
{
    /** @var UuidInterface[] */
    private $productIds;

    /** @var int */
    private $limit;

    /**
     * @param string[] $productIds
     * @param int $limit
     */
    public function __construct(array $productIds, $limit = 12)
    {
        $this->setProductIds($productIds);
        $this->limit = (int) $limit;
    }

    public function getProductIds()
    {
        return $this->productIds;
    }

    public function getLimit()
    {
        return $this->limit;
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
