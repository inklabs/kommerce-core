<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\PaginationDTO;

class PaginationDTOBuilder implements DTOBuilderInterface
{
    /** @var Pagination */
    protected $entity;

    /** @var PaginationDTO */
    protected $entityDTO;

    public function __construct(Pagination $pagination)
    {
        $this->entity = $pagination;

        $this->entityDTO = new PaginationDTO;
        $this->entityDTO->maxResults      = $this->entity->getMaxResults();
        $this->entityDTO->page            = $this->entity->getPage();
        $this->entityDTO->total           = $this->entity->getTotal();
        $this->entityDTO->isTotalIncluded = $this->entity->isTotalIncluded();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
