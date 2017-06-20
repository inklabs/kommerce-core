<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListOrdersQuery implements QueryInterface
{
    /** @var string */
    private $queryString;

    /** @var PaginationDTO */
    private $paginationDTO;

    public function __construct(string $queryString, PaginationDTO $paginationDTO)
    {
        $this->queryString = (string) $queryString;
        $this->paginationDTO = $paginationDTO;
    }

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTO;
    }
}
