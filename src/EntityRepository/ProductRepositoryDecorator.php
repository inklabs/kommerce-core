<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class ProductRepositoryDecorator implements ProductRepositoryInterface
{
    /** @var ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function save(Entity\Product & $product)
    {
        return $this->productRepository->save($product);
    }

    public function create(Entity\Product & $product)
    {
        return $this->productRepository->create($product);
    }

    public function remove(Entity\Product & $product)
    {
        return $this->productRepository->remove($product);
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

    public function getRelatedProductsByIds(array $productIds, $tagIds = [], $limit = 12)
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

    public function getProductsByIds(array $productIds, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByIds($productIds, $pagination);
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProducts($queryString, $pagination);
    }

    public function getAllProductsByIds(array $productIds, Entity\Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProductsByIds($productIds, $pagination);
    }

    public function getRandomProducts($limit)
    {
        return $this->productRepository->getRandomProducts($limit);
    }

    public function loadProductTags(array & $products)
    {
        return $this->productRepository->loadProductTags($products);
    }
}
