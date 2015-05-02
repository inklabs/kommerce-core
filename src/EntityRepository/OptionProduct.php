<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OptionProduct extends AbstractEntityRepository implements OptionProductInterface
{
    public function find($id)
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

    public function save(Entity\OptionProduct & $optionProduct)
    {
        $this->saveEntity($optionProduct);
    }

    public function create(Entity\OptionProduct & $optionProduct)
    {
        $this->persist($optionProduct);
        $this->flush();
    }

    public function persist(Entity\OptionProduct & $optionProduct)
    {
        $this->persistEntity($optionProduct);
    }
}
