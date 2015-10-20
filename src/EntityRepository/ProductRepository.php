<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function findOneBySku($sku)
    {
        return parent::findOneBy(['sku' => $sku]);
    }

    public function getRelatedProducts($products, $limit = 12)
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
        $query = $this->getQueryBuilder()
            ->select('product')
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
            $query
                ->innerJoin('product.tags', 'tag')
                ->andWhere('tag.id IN (:tagIds)')
                ->setParameter('tagIds', $tagIds);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function getProductsByTag(Tag $tag, Pagination & $pagination = null)
    {
        return $this->getProductsByTagId($tag->getId(), $pagination);
    }

    public function getProductsByTagId($tagId, Pagination & $pagination = null)
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
     * @param Product[] $products
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

    public function getProductsByIds(array $productIds, Pagination & $pagination = null)
    {
        $products = $this->getQueryBuilder()
            ->select('product')
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

    public function getAllProducts($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('product')
            ->from('kommerce:Product', 'product');

        if (trim($queryString) !== '') {
            $query
                ->where('product.sku LIKE :query')
                ->orWhere('product.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllProductsByIds(array $productIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('product')
            ->from('kommerce:Product', 'product')
            ->where('product.id IN (:productIds)')
            ->setParameter('productIds', $productIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getRandomProducts($limit)
    {
        return $this->getQueryBuilder()
            ->select('product')
            ->from('kommerce:Product', 'product')
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
