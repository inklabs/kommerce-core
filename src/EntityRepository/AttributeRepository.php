<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\Pagination;

class AttributeRepository extends AbstractRepository implements AttributeRepositoryInterface
{
    public function getAllAttributes($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('Attribute')
            ->from(Attribute::class, 'Attribute');

        if (trim($queryString) !== '') {
            $query
                ->orWhere('Attribute.name LIKE :query')
                ->orWhere('Attribute.description LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
