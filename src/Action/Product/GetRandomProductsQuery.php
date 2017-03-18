<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetRandomProductsQuery implements QueryInterface
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
