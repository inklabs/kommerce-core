<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\ShipmentTracker;

class ShipmentTrackerRepository extends AbstractRepository implements ShipmentTrackerRepositoryInterface
{
    public function getAllAdHocShipments(string $queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('ShipmentTracker')
            ->from(ShipmentTracker::class, 'ShipmentTracker')
            ->where('ShipmentTracker.shipment IS NULL')
            ->orderBy('ShipmentTracker.created');

        if (trim($queryString) !== '') {
            $query->andWhere(
                'ShipmentTracker.trackingCode LIKE :query' .
                ' OR ShipmentTracker.externalId LIKE :query' .
                ' OR ShipmentTracker.shipmentRate.carrier LIKE :query' .
                ' OR ShipmentTracker.shipmentRate.service LIKE :query'
            )->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
