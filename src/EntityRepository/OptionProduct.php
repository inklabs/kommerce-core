<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OptionProduct extends AbstractEntityRepository
{
    /**
     * @return Entity\OptionProduct
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('OptionProduct')
            ->from('kommerce:OptionProduct', 'OptionProduct')

            ->addSelect('Option')
            ->innerJoin('OptionProduct.option', 'Option')

            ->addSelect('Product')
            ->leftJoin('OptionProduct.product', 'Product')

            ->where('OptionProduct.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $optionValues[0];
    }

    /**
     * @return Entity\OptionProduct[]
     */
    public function getAllOptionProductsByIds($optionValueIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('OptionProduct')
            ->from('kommerce:OptionProduct', 'OptionProduct')

            ->addSelect('Option')
            ->innerJoin('OptionProduct.option', 'Option')

            ->addSelect('Product')
            ->leftJoin('OptionProduct.product', 'Product')

            ->where('OptionProduct.id IN (:optionValueIds)')
            ->setParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $optionValues;
    }
}
