<?php
namespace inklabs\kommerce\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator;
use inklabs\kommerce\Entity;

/**
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder setParameter($key, $value, $type)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder select($select)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder distinct($flag)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder addSelect($select)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder delete($delete, $alias)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder update($update, $alias)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder from($from, $alias, $indexBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder indexBy($alias, $indexBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder join($join, $alias, $conditionType, $condition, $indexBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder innerJoin($join, $alias, $conditionType, $condition, $indexBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder leftJoin($join, $alias, $conditionType, $condition, $indexBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder set($key, $value)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder where($predicates)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder andWhere($predicates)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder orWhere($predicates)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder groupBy($groupBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder addGroupBy($groupBy)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder having($having)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder andHaving($having)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder orHaving($having)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder orderBy($sort, $order)
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder addOrderBy($sort, $order)
 */
class QueryBuilder extends \Doctrine\ORM\QueryBuilder
{
    public function paginate(Entity\Pagination & $pagination = null)
    {
        if ($pagination === null) {
            return $this;
        }

        if ($pagination->isTotalIncluded()) {
            $paginator = new Paginator($this);
            $pagination->setTotal(count($paginator));
        }

        return $this
            ->setFirstResult($pagination->getMaxResults() * ($pagination->getPage() - 1))
            ->setMaxResults($pagination->getMaxResults());
    }

    public function tagActiveAndVisible()
    {
        return $this
            ->andWhere('tag.isActive = true')
            ->andWhere('tag.isVisible = true');
    }

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
            ->where($prefix . 'point.latitude BETWEEN :upperLeftLatitude AND :bottomRightLatitude')
            ->andWhere($prefix . 'point.longitude BETWEEN :upperLeftLongitude AND :bottomRightLongitude')
            ->setParameter('upperLeftLatitude', $upperLeft->getLatitude())
            ->setParameter('upperLeftLongitude', $upperLeft->getLongitude())
            ->setParameter('bottomRightLatitude', $bottomRight->getLatitude())
            ->setParameter('bottomRightLongitude', $bottomRight->getLongitude());
    }

    public function withDistance(Entity\Point $point)
    {
        return $this
            ->addSelect(
                'DISTANCE(warehouse.address.point.latitude,warehouse.address.point.longitude,' .
                $point->getLatitude() . ',' . $point->getLongitude() . ') AS distance'
            );
    }
}
