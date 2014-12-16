<?php
namespace inklabs\kommerce\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator;
use inklabs\kommerce\Entity as Entity;

class QueryBuilder extends \Doctrine\ORM\QueryBuilder
{
    public function paginate(Entity\Pagination & $pagination = null)
    {
        if ($pagination === null) {
            return $this;
        }

        if ($pagination->getIsTotalIncluded()) {
            $paginator = new Paginator($this);
            $pagination->setTotal(count($paginator));
        }

        return $this
            ->setFirstResult($pagination->getMaxResults() * ($pagination->getPage() - 1))
            ->setMaxResults($pagination->getMaxResults());
    }

    /**
     * @returns $this
     */
    public function productActiveAndVisible()
    {
        return $this
            ->andWhere('product.isActive = true')
            ->andWhere('product.isVisible = true');
    }

    public function productAvailable()
    {
        return $this
            ->andWhere('(
                product.isInventoryRequired = true
                AND product.quantity > 0
            ) OR (
                product.isInventoryRequired = false
            )');
    }

    public function withinRange(Entity\Point $point, $rangeInMiles = 50, $prefix = '')
    {
        $points = $point->getGeoBox($rangeInMiles);
        $upperLeft = $points[0];
        $bottomRight = $points[1];

        return $this
            ->where($prefix . 'latitude BETWEEN :upperLeftLatitude AND :bottomRightLatitude')
            ->andWhere($prefix . 'longitude BETWEEN :upperLeftLongitude AND :bottomRightLongitude')
            ->setParameter('upperLeftLatitude', $upperLeft->getLatitude())
            ->setParameter('upperLeftLongitude', $upperLeft->getLongitude())
            ->setParameter('bottomRightLatitude', $bottomRight->getLatitude())
            ->setParameter('bottomRightLongitude', $bottomRight->getLongitude());
    }

    public function withDistance(Entity\Point $point)
    {
        return $this
            ->addSelect(
                'DISTANCE(warehouse.address.latitude,warehouse.address.longitude,' .
                $point->getLatitude() . ',' . $point->getLongitude() . ')'
            );
    }

    public function findAll()
    {
        return $this->getQuery()->getResult();
    }
}
