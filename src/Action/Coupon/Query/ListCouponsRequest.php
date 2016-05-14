<?php
namespace inklabs\kommerce\Action\Coupon\Query;

use inklabs\kommerce\EntityDTO\PaginationDTO;

final class ListCouponsRequest
{
    /** @var string */
    private $queryString;

    /** @var PaginationDTO */
    private $paginationDTO;

    /**
     * @param string $queryString
     * @param PaginationDTO $paginationDTO
     */
    public function __construct($queryString, PaginationDTO $paginationDTO)
    {
        $this->queryString = (string) $queryString;
        $this->paginationDTO = $paginationDTO;
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    public function getPaginationDTO()
    {
        return $this->paginationDTO;
    }
}
