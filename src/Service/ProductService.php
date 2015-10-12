<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class ProductService extends AbstractService
{
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

    public function edit(Product & $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->update($product);
    }

    /**
     * @param int $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function findOneById($id)
    {
        return $this->productRepository->findOneById($id);
    }

    /**
     * @param int $productId
     * @param int $tagId
     * @return Tag
     * @throws EntityNotFoundException
     */
    public function addTag($productId, $tagId)
    {
        $product = $product = $this->productRepository->findOneById($productId);
        $tag = $this->tagRepository->findOneById($tagId);

        $product->addTag($tag);

        $this->productRepository->update($product);

        return $tag;
    }

    /**
     * @param int $productId
     * @param int $tagId
     * @throws EntityNotFoundException
     */
    public function removeTag($productId, $tagId)
    {
        $product = $this->productRepository->findOneById($productId);
        $tag = $this->tagRepository->findOneById($tagId);

        $product->removeTag($tag);

        $this->productRepository->update($product);
    }

    /**
     * @param int $productId
     * @param int $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage($productId, $imageId)
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
     * @param Product|Product[] $products
     * @param int $limit
     * @return Product[]
     */
    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }
        /** @var Product[] $products */

        $productIds = [];
        $tagIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->getId();
            foreach ($product->getTags() as $tag) {
                $tagIds[] = $tag->getId();
            }
        }

        return $this->productRepository->getRelatedProductsByIds($productIds, $tagIds, $limit);
    }

    /**
     * @param Tag $tag
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByTag(Tag $tag, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTagId($tag->getId(), $pagination);
    }

    /**
     * @param int[] $productIds
     * @param Pagination $pagination
     * @return Product[]
     */
    public function getProductsByIds($productIds, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByIds($productIds, $pagination);
    }

    /**
     * @param int[] $productIds
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
