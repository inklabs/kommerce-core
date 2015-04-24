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
     * @return View\Product[]
     */
    public function getRandomProducts($limit);

    /**
     * @param Entity\EntityInterface $entity
     */
    public function create(Entity\EntityInterface & $entity);

    /**
     * @param Entity\EntityInterface $entity
     */
    public function save(Entity\EntityInterface & $entity);
}
