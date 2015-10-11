<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class OptionProductRepository extends AbstractRepository implements OptionProductRepositoryInterface
{
    public function findOneById($id)
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

    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null)
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
