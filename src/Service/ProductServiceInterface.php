<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface ProductServiceInterface
{
    public function create(Product & $product);
    public function update(Product & $product);
    public function delete(Product $product);

    /**
     * @param UuidInterface $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @param UuidInterface $productId
     * @param UuidInterface $tagId
     * @throws EntityNotFoundException
     */
    public function addTag(UuidInterface $productId, UuidInterface $tagId);

    /**
     * @param UuidInterface $productId
     * @param UuidInterface $tagId
     * @throws EntityNotFoundException
     */
    public function removeTag(UuidInterface $productId, UuidInterface $tagId);

    /**
     * @param UuidInterface $productId
     * @param UuidInterface $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage(UuidInterface $productId, UuidInterface $imageId);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProducts($queryString = null, Pagination & $pagination = null);

    /**
     * @param Product|Product[] $products
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProducts($products, $limit = 12);

    /**
     * @param UuidInterface[] $productIds
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProductsByIds(array $productIds, $limit = 12);

    /**
     * @param UuidInterface $tagId
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTagId(UuidInterface $tagId, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $productIds
     * @param Pagination $pagination  TODO: Remove $pagination
     * @return Product[]
     */
    public function getProductsByIds($productIds, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProductsByIds($productIds, Pagination & $pagination = null);

    /**
     * @param int $limit
     * @return Product[]
     */
    public function getRandomProducts($limit);
}
