<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

interface ProductRepositoryInterface
{
    public function save(Entity\Product & $product);
    public function create(Entity\Product & $product);
    public function remove(Entity\Product & $product);

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
     * @param int[] $productIds
     * @param int[] $tagIds
     * @param int $limit
     * @return Entity\Product[]
     */
    public function getRelatedProductsByIds(array $productIds, $tagIds = [], $limit = 12);

    /**
     * Load product tags to avoid query in loop for pricing
     *
     * @param Entity\Product[] $products
     */
    public function loadProductTags(array & $products);

    /**
     * @param Entity\Tag $tag
     * @param Entity\Pagination $pagination
     * @return Entity\Product[]
     */
    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null);

    /**
     * @param int $tagId
     * @param Entity\Pagination $pagination
     * @return Entity\Product[]
     */
    public function getProductsByTagId($tagId, Entity\Pagination & $pagination = null);

    /**
     * @param int[] $productIds
     * @param Entity\Pagination $pagination
     * @return Entity\Product[]
     */
    public function getProductsByIds(array $productIds, Entity\Pagination & $pagination = null);

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Product[]
     */
    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null);

    /**
     * @param int[] $productIds
     * @param Entity\Pagination $pagination
     * @return Entity\Product[]
     */
    public function getAllProductsByIds(array $productIds, Entity\Pagination & $pagination = null);

    /**
     * @param int $limit
     * @return Entity\Product[]
     */
    public function getRandomProducts($limit);
}
