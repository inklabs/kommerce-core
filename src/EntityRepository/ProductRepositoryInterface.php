<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;

/**
 * @method Product findOneById($id)
 */
interface ProductRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $sku
     * @return Product
     */
    public function findOneBySku($sku);

    /**
     * @param Product[] $products
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProducts($products, $limit = 12);

    /**
     * @param int[] $productIds
     * @param int[] $tagIds
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProductsByIds(array $productIds, $tagIds = [], $limit = 12);

    /**
     * Load product tags to avoid query in loop for pricing
     *
     * @param Product[] $products
     */
    public function loadProductTags(array & $products);

    /**
     * @param Tag $tag
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTag(Tag $tag, Pagination & $pagination = null);

    /**
     * @param int $tagId
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTagId($tagId, Pagination & $pagination = null);

    /**
     * @param int[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByIds(array $productIds, Pagination & $pagination = null);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProducts($queryString = null, Pagination & $pagination = null);

    /**
     * @param int[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProductsByIds(array $productIds, Pagination & $pagination = null);

    /**
     * @param int $limit
     * @return Product[]
     */
    public function getRandomProducts($limit);
}
