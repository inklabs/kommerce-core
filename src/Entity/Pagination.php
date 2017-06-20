<?php
namespace inklabs\kommerce\Entity;

class Pagination
{
    /** @var int|null */
    protected $maxResults;

    /** @var int|null */
    protected $page;

    /** @var int|null */
    protected $total;

    /** @var bool */
    protected $shouldIncludeTotal;

    public function __construct(?int $maxResults = 10, ?int $page = 1, bool $shouldIncludeTotal = true)
    {
        $this->maxResults = $maxResults;
        $this->page = $page;
        $this->shouldIncludeTotal = $shouldIncludeTotal;
    }

    public function getMaxResults(): ?int
    {
        return $this->maxResults;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setTotal(int $total)
    {
        $this->total = $total;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function isTotalIncluded(): bool
    {
        return $this->total !== null;
    }

    public function shouldIncludeTotal(): bool
    {
        return $this->shouldIncludeTotal;
    }
}
