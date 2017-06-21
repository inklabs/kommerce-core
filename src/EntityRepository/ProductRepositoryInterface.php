<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Product findOneById(UuidInterface $id)
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    public function findOneBySku(string $sku): Product;

    /**
     * @param UuidInterface[] $productIds
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProductsByIds(array $productIds, int $limit = 12);

    /**
     * Load product tags to avoid query in loop for pricing
     *
     * @param Product[] $products
     */
    public function loadProductTags(array & $products);

    /**
     * @param UuidInterface $tagId
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTagId(UuidInterface $tagId, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByIds(array $productIds, Pagination & $pagination = null);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProducts(string $queryString = null, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProductsByIds(array $productIds, Pagination & $pagination = null);

    /**
     * @param int $limit
     * @return Product[]
     */
    public function getRandomProducts(int $limit);
}
