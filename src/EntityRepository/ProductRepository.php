<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Lib\UuidInterface;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function findOneBySku($sku)
    {
        return parent::findOneBy(['sku' => $sku]);
    }

    /**
     * @param UuidInterface[] $productIds
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProductsByIds(array $productIds, $limit = 12)
    {
        $tagIdsQuery = $this->getQueryBuilder()
            ->select('DISTINCT Tag2.id')
            ->from(Product::class, 'Product2')
            ->where('Product2.id IN (:productIds)')
            ->innerJoin('Product2.tags', 'Tag2')
            ->getQuery();

        return $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product')
            ->innerJoin('Product.tags', 'Tag')
            ->where('Product.id NOT IN (:productIds)')
            ->andWhere('Tag.id IN (' . $tagIdsQuery->getDQL() . ')')
            ->setIdParameter('productIds', $productIds)
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND(:rand) as HIDDEN rand')
            ->setParameter('rand', crc32(json_encode($productIds)))
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getProductsByTagId(UuidInterface $tagId, Pagination & $pagination = null)
    {
        $products = $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product')
            ->innerJoin('Product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->setIdParameter('tagId', $tagId)
            ->productActiveAndVisible()
            ->productAvailable()
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
        $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product')
            ->where('Product.id IN (:productIds)')
            ->addSelect('tag2')
            ->leftJoin('Product.tags', 'tag2')
            ->setEntityParameter('productIds', $products)
            ->getQuery()
            ->getResult();
    }

    public function getProductsByIds(array $productIds, Pagination & $pagination = null)
    {
        $products = $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product')
            ->where('Product.id IN (:productIds)')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setIdParameter('productIds', $productIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        $this->loadProductTags($products);

        return $products;
    }

    public function getAllProducts($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product');

        if (trim($queryString) !== '') {
            $query
                ->where('Product.sku LIKE :query')
                ->orWhere('Product.name LIKE :query')
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
            ->select('Product')
            ->from(Product::class, 'Product')
            ->where('Product.id IN (:productIds)')
            ->setIdParameter('productIds', $productIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getRandomProducts($limit)
    {
        return $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product')
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
