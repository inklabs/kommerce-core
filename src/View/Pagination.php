<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Pagination implements ViewInterface
{
    public $maxResults;
    public $page;
    public $total;
    public $isTotalIncluded;

    public function __construct(Entity\Pagination $pagination)
    {
        $this->maxResults      = $pagination->getMaxResults();
        $this->page            = $pagination->getPage();
        $this->total           = $pagination->getTotal();
        $this->isTotalIncluded = $pagination->isTotalIncluded();
    }

    public function export()
    {
        return $this;
    }
}
