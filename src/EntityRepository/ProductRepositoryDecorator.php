<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;

class ProductRepositoryDecorator implements ProductRepositoryInterface
{
    /** @var ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function findOneById($id)
    {
        return $this->productRepository->findOneById($id);
    }

    public function findOneBySku($sku)
    {
        return $this->productRepository->findOneBySku($sku);
    }

    public function getRelatedProducts($products, $limit = 12)
    {
        return $this->productRepository->getRelatedProducts($products, $limit);
    }

    public function getRelatedProductsByIds(array $productIds, $tagIds = [], $limit = 12)
    {
        return $this->productRepository->getRelatedProductsByIds($productIds, $tagIds, $limit);
    }

    public function getProductsByTag(Tag $tag, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTag($tag, $pagination);
    }

    public function getProductsByTagId($tagId, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByTagId($tagId, $pagination);
    }

    public function getProductsByIds(array $productIds, Pagination & $pagination = null)
    {
        return $this->productRepository->getProductsByIds($productIds, $pagination);
    }

    public function getAllProducts($queryString = null, Pagination & $pagination = null)
    {
        return $this->productRepository->getAllProducts($queryString, $pagination);
    }

    public function getAllProductsByIds(array $productIds, Pagination & $pagination = null)
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

    public function getQueryBuilder()
    {
        return $this->productRepository->getQueryBuilder();
    }

    public function save(EntityInterface & $entity)
    {
        return $this->productRepository->save($entity);
    }

    public function create(EntityInterface & $entity)
    {
        return $this->productRepository->create($entity);
    }

    public function remove(EntityInterface $entity)
    {
        return $this->productRepository->remove($entity);
    }

    public function persist(EntityInterface & $entity)
    {
        return $this->productRepository->persist($entity);
    }

    public function merge(EntityInterface & $entity)
    {
        return $this->productRepository->merge($entity);
    }

    public function flush()
    {
        return $this->productRepository->flush();
    }
}
