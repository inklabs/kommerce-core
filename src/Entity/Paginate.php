<?php
namespace inklabs\kommerce\Entity;

use Doctrine\ORM\Tools\Pagination\Paginator;

class Paginate
{
    public $maxResults;
    public $page;
    public $total;
    public $loadTotal = true;

    public function __construct($maxResults = 10, $page = 1)
    {
        $this->maxResults = $maxResults;
        $this->page = $page;
    }

    public function paginate(\Doctrine\ORM\QueryBuilder $query)
    {
        if ($this->loadTotal === true) {
            $paginator = new Paginator($query);
            $this->total = count($paginator);
        }

        return $query
            ->setFirstResult($this->maxResults * ($this->page - 1))
            ->setMaxResults($this->maxResults);
    }
}
