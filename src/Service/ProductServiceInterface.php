<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;

interface ProductServiceInterface
{
    public function create(Product & $product);
    public function update(Product & $product);

    /**
     * @param int $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

    /**
     * @param int $productId
     * @param int $tagId
     * @return Tag
     * @throws EntityNotFoundException
     */
    public function addTag($productId, $tagId);

    /**
     * @param int $productId
     * @param int $tagId
     * @throws EntityNotFoundException
     */
    public function removeTag($productId, $tagId);

    /**
     * @param int $productId
     * @param int $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage($productId, $imageId);

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
     * @param Tag $tag
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTag(Tag $tag, Pagination & $pagination = null);

    /**
     * @param int[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByIds($productIds, Pagination & $pagination = null);

    /**
     * @param int[] $productIds
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
