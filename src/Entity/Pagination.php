<?php
namespace inklabs\kommerce\Entity;

class Pagination
{
    /** @var int */
    protected $maxResults;

    /** @var int */
    protected $page;

    /** @var int|null */
    protected $total;

    /** @var bool */
    protected $shouldIncludeTotal;

    public function __construct($maxResults = 10, $page = 1, $shouldIncludeTotal = true)
    {
        $this->maxResults = $maxResults;
        $this->page = $page;
        $this->shouldIncludeTotal = $shouldIncludeTotal;
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

    public function isTotalIncluded()
    {
        return $this->total !== null;
    }

    public function shouldIncludeTotal()
    {
        return $this->shouldIncludeTotal;
    }
}
