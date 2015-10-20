<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class OptionProductRepository extends AbstractRepository implements OptionProductRepositoryInterface
{
    public function findOneById($id)
    {
        return $this->getQueryBuilder()
            ->select('OptionProduct')
            ->from('kommerce:OptionProduct', 'OptionProduct')

            ->addSelect('Option')
            ->innerJoin('OptionProduct.option', 'Option')

            ->addSelect('Product')
            ->leftJoin('OptionProduct.product', 'Product')

            ->where('OptionProduct.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('OptionProduct')
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
    }
}
