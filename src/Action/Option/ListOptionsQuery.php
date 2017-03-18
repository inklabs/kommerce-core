<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListOptionsQuery implements QueryInterface
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
