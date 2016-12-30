<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Attribute findOneById(UuidInterface $id)
 */
interface AttributeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $queryString
     * @param null|Pagination $pagination
     * @return Attribute[]
     */
    public function getAllAttributes($queryString, Pagination & $pagination = null);
}
