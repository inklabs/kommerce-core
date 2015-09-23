<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\PaginationDTO;

class PaginationDTOBuilder
{
    /** @var Pagination */
    protected $pagination;

    /** @var PaginationDTO */
    protected $paginationDTO;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;

        $this->paginationDTO = new PaginationDTO;
        $this->paginationDTO->maxResults      = $this->pagination->getMaxResults();
        $this->paginationDTO->page            = $this->pagination->getPage();
        $this->paginationDTO->total           = $this->pagination->getTotal();
        $this->paginationDTO->isTotalIncluded = $this->pagination->isTotalIncluded();
    }

    public function build()
    {
        return $this->paginationDTO;
    }
}
