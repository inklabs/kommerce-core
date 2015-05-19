<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class ProductDecorator implements ProductInterface
{
    /** @var ProductInterface */
    protected $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->productRepository->findOneBy($criteria, $orderBy);
    }

    public function getRelatedProducts(array $products, $limit = 12)
    {
        return $this->productRepository->getRelatedProducts($products, $limit);
    }

    public function getRelatedProductsByIds($productIds, $tagIds = null, $limit = 12)
    {
        return $this->productRepository->getRelatedProductsByIds($productIds, $tagIds, $limit);
    }

    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTag($tag, $pagination);
    }

    public function getProductsByTagId($tagId, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTagId($tagId, $pagination);
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByIds($productIds, $pagination);
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProducts($queryString, $pagination);
    }

    public function getAllProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProductsByIds($productIds, $pagination);
    }

    public function getRandomProducts($limit)
    {
        return $this->productRepository->getRandomProducts($limit);
    }

    public function create(Entity\Product & $product)
    {
        return $this->productRepository->create($product);
    }

    public function save(Entity\Product & $product)
    {
        return $this->productRepository->save($product);
    }

    public function persist(Entity\Product & $product)
    {
        return $this->productRepository->persist($product);
    }

    public function flush()
    {
        return $this->productRepository->flush();
    }
}
