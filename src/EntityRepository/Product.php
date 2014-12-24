<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

class Product extends EntityRepository
{
    /**
     * @return Entity\Product[]
     */
    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }

        $productIds = [];
        $tagIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->getId();
            foreach ($product->getTags() as $tag) {
                $tagIds[] = $tag->getId();
            }
        }

        return $this->getRelatedProductsByIds($productIds, $tagIds, $limit);
    }

    /**
     * @return Entity\Product[]
     */
    public function getRelatedProductsByIds($productIds, $tagIds = null, $limit = 12)
    {
        $qb = $this->getQueryBuilder();

        $query = $qb->select('product')
            ->from('kommerce:Product', 'product')
            ->where('product.id NOT IN (:productId)')
            ->setParameter('productId', $productIds)
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND(:rand) as HIDDEN rand')
            ->setParameter('rand', array_sum($productIds))
            ->orderBy('rand')
            ->setMaxResults($limit);

        if (! empty($tagIds)) {
            $query = $query
                ->innerJoin('product.tags', 'tag')
                ->andWhere('tag.id IN (:tagIds)')
                ->setParameter('tagIds', $tagIds);
        }

        $products = $query
            ->getQuery()
            ->getResult();

        return $products;
    }

    /**
     * @return Entity\Product[]
     */
    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null)
    {
        return $this->getProductsByTagId($tag->getId(), $pagination);
    }

    /**
     * @return Entity\Product[]
     */
    public function getProductsByTagId($tagId, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('kommerce:Product', 'product')
            ->innerJoin('product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('tagId', $tagId)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $products;
    }

    /**
     * @return Entity\View\Product[]
     */
    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id IN (:productIds)')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('productIds', $productIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $products;
    }

    /**
     * @return Entity\View\Product[]
     */
    public function getRandomProducts($limit)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $products;
    }
}
