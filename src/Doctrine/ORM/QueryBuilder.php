<?php
namespace inklabs\kommerce\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator;
use inklabs\kommerce\Entity\Pagination;

class QueryBuilder extends \Doctrine\ORM\QueryBuilder
{
    public function paginate(Pagination & $pagination = null)
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

    public function findAll()
    {
        return $this->getQuery()->getResult();
    }
}
