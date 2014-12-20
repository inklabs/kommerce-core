<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Pagination
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
        $this->isTotalIncluded = $pagination->getIsTotalIncluded();
    }
}
