<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\Query\RequestInterface;

class ListTagsRequest implements RequestInterface
{
    /** @var string */
    private $queryString;

    /** @var Pagination */
    private $pagination;

    /**
     * @param string $queryString
     * @param Pagination $pagination
     */
    public function __construct($queryString, Pagination $pagination)
    {
        $this->queryString = (string) $queryString;
        $this->pagination = $pagination;
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    public function getPagination()
    {
        return $this->pagination;
    }
}
