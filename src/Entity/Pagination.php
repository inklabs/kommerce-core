<?php
namespace inklabs\kommerce\Entity;

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
        $this->isTotalIncluded = true;
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
        $this->isTotalIncluded = $isTotalIncluded;
    }

    public function getIsTotalIncluded()
    {
        return $this->isTotalIncluded;
    }

    /**
     * @return \stdClass
     */
    public function getData()
    {
        $obj = new \stdClass;
        $obj->maxResults      = $this->maxResults;
        $obj->page            = $this->page;
        $obj->total           = $this->total;
        $obj->isTotalIncluded = $this->isTotalIncluded;
        return $obj;
    }

    public function getView()
    {
        return new View\Pagination($this);
    }
}
