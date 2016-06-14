<?php
namespace inklabs\kommerce\Action\Product\Query;

final class GetRandomProductsRequest
{
    /** @var int */
    private $limit;

    /**
     * @param int $limit
     */
    public function __construct($limit)
    {
        $this->limit = (int) $limit;
    }

    public function getLimit()
    {
        return $this->limit;
    }
}
