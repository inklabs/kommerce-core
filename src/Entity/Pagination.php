<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\View;

class Pagination
{
    protected $maxResults;
    protected $page;
    protected $total;
    protected $isTotalIncluded;

    public function __construct($maxResults = 10, $page = 1)
    {
        $this->maxResults = $maxResults;
        $this->page = $page;

        $this->setIsTotalIncluded(true);
    }

    public function getMaxResults()
    {
        return $this->maxResults;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setIsTotalIncluded($isTotalIncluded)
    {
        $this->isTotalIncluded = (bool) $isTotalIncluded;
    }

    public function isTotalIncluded()
    {
        return $this->isTotalIncluded;
    }

    public function getData()
    {
        $pagination = new \stdClass;
        $pagination->maxResults      = $this->maxResults;
        $pagination->page            = $this->page;
        $pagination->total           = $this->total;
        $pagination->isTotalIncluded = $this->isTotalIncluded;

        return $pagination;
    }

    public function getView()
    {
        return new View\Pagination($this);
    }

    public function getDTOBuilder()
    {
        return new PaginationDTOBuilder($this);
    }
}
