<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;

class Product extends AbstractService
{
    /** @var EntityRepository\ProductInterface */
    private $productRepository;

    /** @var EntityRepository\TagInterface */
    private $tagRepository;

    /** @var EntityRepository\ImageInterface */
    private $imageRepository;

    public function __construct(
        EntityRepository\ProductInterface $productRepository,
        EntityRepository\TagInterface $tagRepository,
        EntityRepository\ImageInterface $imageRepository
    ) {
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
        $this->imageRepository = $imageRepository;
    }

    public function create(Entity\Product & $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->create($product);
    }

    public function edit(Entity\Product & $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->save($product);
    }

    /**
     * @param int $id
     * @return Entity\Product|null
     */
    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * @param int $productId
     * @param int $tagId
     * @return Entity\Tag
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

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProducts($queryString, $pagination);
    }

    /**
     * @param Entity\Product|Entity\Product[] $products
     * @param int $limit
     * @return Entity\Product[]
     */
    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }
        /** @var Entity\Product[] $products */

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

    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTagId($tag->getId(), $pagination);
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByIds($productIds, $pagination);
    }

    public function getAllProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProductsByIds($productIds, $pagination);
    }

    public function getRandomProducts($limit)
    {
        return $this->productRepository->getRandomProducts($limit);
    }

    /**
     * @param int $productId
     * @return Entity\Product
     * @throws \LogicException
     */
    public function getProductAndThrowExceptionIfMissing($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new \LogicException('Missing Product');
        }

        return $product;
    }

    /**
     * @param int $tagId
     * @return Entity\Tag
     * @throws \LogicException
     */
    private function getTagAndThrowExceptionIfMissing($tagId)
    {
        $tag = $this->tagRepository->find($tagId);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        return $tag;
    }

    /**
     * @param int $imageId
     * @return Entity\Image
     * @throws \LogicException
     */
    private function getImageAndThrowExceptionIfMissing($imageId)
    {
        $image = $this->imageRepository->find($imageId);

        if ($image === null) {
            throw new \LogicException('Missing Image');
        }

        return $image;
    }
}
