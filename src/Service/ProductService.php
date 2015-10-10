<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use LogicException;

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
        $this->productRepository->save($product);
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * @param int $productId
     * @param int $tagId
     * @return Tag
     */
    public function addTag($productId, $tagId)
    {
        $product = $this->getProductAndThrowExceptionIfMissing($productId);
        $tag = $this->getTagAndThrowExceptionIfMissing($tagId);

        $product->addTag($tag);

        $this->productRepository->save($product);

        return $tag;
    }

    /**
     * @param int $productId
     * @param int $tagId
     */
    public function removeTag($productId, $tagId)
    {
        $product = $this->getProductAndThrowExceptionIfMissing($productId);
        $tag = $this->getTagAndThrowExceptionIfMissing($tagId);

        $product->removeTag($tag);

        $this->productRepository->save($product);
    }

    /**
     * @param int $productId
     * @param int $imageId
     */
    public function removeImage($productId, $imageId)
    {
        $product = $this->getProductAndThrowExceptionIfMissing($productId);
        $image = $this->getImageAndThrowExceptionIfMissing($imageId);

        $product->removeImage($image);

        $this->productRepository->save($product);

        if ($image->getTag() === null) {
            $this->imageRepository->remove($image);
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

    /**
     * @param int $productId
     * @return Product
     * @throws LogicException
     */
    public function getProductAndThrowExceptionIfMissing($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new LogicException('Missing Product');
        }

        return $product;
    }

    /**
     * @param int $tagId
     * @return Tag
     * @throws LogicException
     */
    private function getTagAndThrowExceptionIfMissing($tagId)
    {
        $tag = $this->tagRepository->find($tagId);

        if ($tag === null) {
            throw new LogicException('Missing Tag');
        }

        return $tag;
    }

    /**
     * @param int $imageId
     * @return Image
     * @throws LogicException
     */
    private function getImageAndThrowExceptionIfMissing($imageId)
    {
        $image = $this->imageRepository->find($imageId);

        if ($image === null) {
            throw new LogicException('Missing Image');
        }

        return $image;
    }
}
