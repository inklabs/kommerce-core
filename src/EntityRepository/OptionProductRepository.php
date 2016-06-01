<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

class OptionProductRepository extends AbstractRepository implements OptionProductRepositoryInterface
{
    public function findOneById(UuidInterface $id)
    {
        return $this->getQueryBuilder()
            ->select('OptionProduct')
            ->from(OptionProduct::class, 'OptionProduct')

            ->addSelect('Option')
            ->innerJoin('OptionProduct.option', 'Option')

            ->addSelect('Product')
            ->leftJoin('OptionProduct.product', 'Product')

            ->where('OptionProduct.id = :id')
            ->setIdParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('OptionProduct')
            ->from(OptionProduct::class, 'OptionProduct')

            ->addSelect('Option')
            ->innerJoin('OptionProduct.option', 'Option')

            ->addSelect('Product')
            ->leftJoin('OptionProduct.product', 'Product')

            ->where('OptionProduct.id IN (:optionValueIds)')
            ->setIdParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
