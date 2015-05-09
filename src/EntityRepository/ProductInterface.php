<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

interface ProductInterface
{
    /**
     * @param int $id
     * @return Entity\Product
     */
    public function find($id);

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Entity\Product
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param Entity\Product[] $products
     * @param int $limit
     * @return Entity\Product[]
     */
    public function getRelatedProducts(array $products, $limit = 12);

    /**
     * @param int $productIds
     * @param int $tagIds
     * @param int $limit
     * @return Entity\Product[]
     */
    public function getRelatedProductsByIds($productIds, $tagIds = null, $limit = 12);

    /**
     * @return Entity\Product[]
     */
    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination &$pagination = null);

    /**
     * @return Entity\Product[]
     */
    public function getProductsByTagId($tagId, Entity\Pagination &$pagination = null);

    /**
     * @return Entity\Product[]
     */
    public function getProductsByIds($productIds, Entity\Pagination &$pagination = null);

    /**
     * @return Entity\Product[]
     */
    public function getAllProducts($queryString = null, Entity\Pagination &$pagination = null);

    /**
     * @return Entity\Product[]
     */
    public function getAllProductsByIds($productIds, Entity\Pagination &$pagination = null);

    /**
     * @return Entity\Product[]
     */
    public function getRandomProducts($limit);

    /**
     * @param Entity\Product $product
     */
    public function create(Entity\Product & $product);

    /**
     * @param Entity\Product $product
     */
    public function save(Entity\Product & $product);

    /**
     * @param Entity\Product $product
     */
    public function persist(Entity\Product & $product);

    public function flush();
}
