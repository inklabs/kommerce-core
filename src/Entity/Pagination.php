<?php
namespace inklabs\kommerce\Entity;

class Pagination
{
    /** @var int */
    protected $maxResults;

    /** @var int */
    protected $page;

    /** @var int */
    protected $total;

    /** @var bool */
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

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = (int) $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param bool $isTotalIncluded
     */
    public function setIsTotalIncluded($isTotalIncluded)
    {
        $this->isTotalIncluded = (bool) $isTotalIncluded;
    }

    public function isTotalIncluded()
    {
        return $this->isTotalIncluded;
    }
}
