<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Product extends AbstractEntityRepository implements ProductInterface
{
    public function save(Entity\Product & $product)
    {
        $this->saveEntity($product);
    }

    public function create(Entity\Product & $product)
    {
        $this->createEntity($product);
    }

    public function remove(Entity\Product & $product)
    {
        $this->removeEntity($product);
    }

    public function getRelatedProducts(array $products, $limit = 12)
    {
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

    public function getRelatedProductsByIds(array $productIds, $tagIds = null, $limit = 12)
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

    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null)
    {
        return $this->getProductsByTagId($tag->getId(), $pagination);
    }

    public function getProductsByTagId($tagId, Entity\Pagination & $pagination = null)
    {
        $products = $this->getQueryBuilder()
            ->select('product')
            ->from('kommerce:Product', 'product')
            ->innerJoin('product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('tagId', $tagId)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        $this->loadProductTags($products);

        return $products;
    }

    /**
     * Load product tags to avoid query in loop for pricing
     *
     * @param Entity\Product[] $products
     */
    public function loadProductTags(array & $products)
    {
        $productIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->getId();
        }

        $this->getQueryBuilder()
            ->select('product')
            ->from('kommerce:Product', 'product')
            ->where('product.id IN (:productIds)')
            ->addSelect('tag2')
            ->leftJoin('product.tags', 'tag2')
            ->setParameter('productIds', $productIds)
            ->getQuery()
            ->getResult();
    }

    public function getProductsByIds(array $productIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('kommerce:Product', 'product')
            ->where('product.id IN (:productIds)')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('productIds', $productIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        $this->loadProductTags($products);

        return $products;
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('kommerce:Product', 'product');

        if ($queryString !== null) {
            $products = $products
                ->where('product.sku LIKE :query')
                ->orWhere('product.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        $products = $products
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $products;
    }

    public function getAllProductsByIds(array $productIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('kommerce:Product', 'product')
            ->where('product.id IN (:productIds)')
            ->setParameter('productIds', $productIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $products;
    }

    public function getRandomProducts($limit)
    {
        $qb = $this->getQueryBuilder();

        $products = $qb->select('product')
            ->from('kommerce:Product', 'product')
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
