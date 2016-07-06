<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\UuidInterface;

class ProductService implements ProductServiceInterface
{
    use EntityValidationTrait;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        TagRepositoryInterface $tagRepository,
        ImageRepositoryInterface $imageRepository
    ) {
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
        $this->imageRepository = $imageRepository;
    }

    public function create(Product & $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->create($product);
    }

    public function update(Product & $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->update($product);
    }

    public function delete(Product $product)
    {
        $this->productRepository->delete($product);
    }

    /**
     * @param UuidInterface $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id)
    {
        return $this->productRepository->findOneById($id);
    }

    /**
     * @param UuidInterface $productId
     * @param UuidInterface $tagId
     * @throws EntityNotFoundException
     */
    public function addTag(UuidInterface $productId, UuidInterface $tagId)
    {
        $product = $this->productRepository->findOneById($productId);
        $tag = $this->tagRepository->findOneById($tagId);

        $product->addTag($tag);

        $this->productRepository->update($product);
    }

    /**
     * @param UuidInterface $productId
     * @param UuidInterface $tagId
     * @throws EntityNotFoundException
     */
    public function removeTag(UuidInterface $productId, UuidInterface $tagId)
    {
        $product = $this->productRepository->findOneById($productId);
        $tag = $this->tagRepository->findOneById($tagId);

        $product->removeTag($tag);

        $this->productRepository->update($product);
    }

    /**
     * @param UuidInterface $productId
     * @param UuidInterface $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage(UuidInterface $productId, UuidInterface $imageId)
    {
        $product = $this->productRepository->findOneById($productId);
        $image = $this->imageRepository->findOneById($imageId);

        $product->removeImage($image);

        $this->productRepository->update($product);

        if ($image->getTag() === null) {
            $this->imageRepository->delete($image);
        }
    }

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProducts($queryString = null, Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProducts($queryString, $pagination);
    }

    /**
     * @param UuidInterface[] $productIds
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProductsByIds(array $productIds, $limit = 12)
    {
        return $this->productRepository->getRelatedProductsByIds($productIds, $limit);
    }

    /**
     * @param UuidInterface $tagId
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTagId(UuidInterface $tagId, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTagId($tagId, $pagination);
    }

    /**
     * @param UuidInterface[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByIds($productIds, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByIds($productIds, $pagination);
    }

    /**
     * @param UuidInterface[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getAllProductsByIds($productIds, Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProductsByIds($productIds, $pagination);
    }

    /**
     * @param int $limit
     * @return Product[]
     */
    public function getRandomProducts($limit)
    {
        return $this->productRepository->getRandomProducts($limit);
    }
}
