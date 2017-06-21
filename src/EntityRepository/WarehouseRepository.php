<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;

class WarehouseRepository extends AbstractRepository implements WarehouseRepositoryInterface
{
    public function findByPoint(Point $point, int $rangeInMiles = 50, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('Warehouse')
            ->from(Warehouse::class, 'Warehouse')
            ->withDistance($point)
            ->withinRange($point, $rangeInMiles, 'Warehouse.address.')
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllWarehouses(string $queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('Warehouse')
            ->from(Warehouse::class, 'Warehouse');

        if (trim($queryString) !== '') {
            $query->andWhere(
                'Warehouse.name LIKE :query' .
                ' OR Warehouse.address.attention LIKE :query' .
                ' OR Warehouse.address.company LIKE :query' .
                ' OR Warehouse.address.zip5 LIKE :query'
            )->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
