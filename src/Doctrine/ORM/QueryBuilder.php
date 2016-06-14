<?php
namespace inklabs\kommerce\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator;
use inklabs\kommerce\Entity\IdEntityInterface;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Lib\UuidInterface;

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
 * @method QueryBuilder|\Doctrine\ORM\QueryBuilder setMaxResults($maxResults)
 */
class QueryBuilder extends \Doctrine\ORM\QueryBuilder
{
    public function paginate(Pagination & $pagination = null)
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
            ->andWhere('Tag.isActive = true')
            ->andWhere('Tag.isVisible = true');
    }

    public function productActiveAndVisible()
    {
        return $this
            ->andWhere('Product.isActive = true')
            ->andWhere('Product.isVisible = true');
    }

    public function productAvailable()
    {
        return $this
            ->andWhere('(
                Product.isInventoryRequired = true
                AND Product.quantity > 0
            ) OR (
                Product.isInventoryRequired = false
            )');
    }

    public function withinRange(Point $point, $rangeInMiles = 50, $prefix = '')
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

    public function withDistance(Point $point)
    {
        return $this
            ->addSelect(
                'DISTANCE(Warehouse.address.point.latitude,Warehouse.address.point.longitude,' .
                $point->getLatitude() . ',' . $point->getLongitude() . ') AS distance'
            );
    }

    /**
     * @param string|integer $key   The parameter position or name.
     * @param mixed          $value The parameter value.
     * @param string|null    $type  PDO::PARAM_* or \Doctrine\DBAL\Types\Type::* constant
     * @return self
     */
    public function setIdParameter($key, $value, $type = null)
    {
        return $this
            ->setParameter($key, $this->getBytesFromIds($value), $type);
    }

    /**
     * @param string|integer $key   The parameter position or name.
     * @param mixed          $value The parameter value.
     * @param string|null    $type  PDO::PARAM_* or \Doctrine\DBAL\Types\Type::* constant
     * @return self
     */
    public function setEntityParameter($key, $value, $type = null)
    {
        return $this
            ->setParameter($key, $this->getBytesFromEntities($value), $type);
    }

    /**
     * @param IdEntityInterface | IdEntityInterface[] $entities
     * @return string | string[]
     */
    private function getBytesFromEntities(& $entities)
    {
        if (is_array($entities)) {
            $entityIds = [];
            foreach ($entities as $entity) {
                $entityIds[] = $entity->getId();
            }
            return $this->getBytesFromIds($entityIds);
        } else {
            return $this->getBytesFromId($entities->getId());
        }
    }

    /**
     * @param UuidInterface | UuidInterface[] $ids
     * @return string | string[]
     */
    private function getBytesFromIds(& $ids)
    {
        if (is_array($ids)) {
            return $this->getBytesFromIdsArray($ids);
        }

        return $this->getBytesFromId($ids);
    }

    /**
     * @param UuidInterface[] $ids
     * @return string[]
     */
    private function getBytesFromIdsArray(array & $ids)
    {
        $idBytes = [];
        foreach ($ids as $id) {
            $idBytes[] = $this->getBytesFromId($id);
        }

        return $idBytes;
    }

    /**
     * @param UuidInterface $id
     * @return string binary bytes
     */
    private function getBytesFromId(UuidInterface $id)
    {
        return $id->getBytes();
    }
}
