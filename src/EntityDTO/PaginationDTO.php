<?php
namespace inklabs\kommerce\EntityDTO;

class PaginationDTO
{
    /** @var int */
    public $maxResults;

    /** @var int */
    public $page;

    /** @var int */
    public $total;

    /** @var bool */
    public $isTotalIncluded;
}
