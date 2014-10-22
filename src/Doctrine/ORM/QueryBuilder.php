<?php
namespace inklabs\kommerce\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Collections\ArrayCollection;

class QueryBuilder extends \Doctrine\ORM\QueryBuilder
{
    public function paginate(\inklabs\kommerce\Entity\Pagination & $pagination = null)
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

    public function productActiveVisible()
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
