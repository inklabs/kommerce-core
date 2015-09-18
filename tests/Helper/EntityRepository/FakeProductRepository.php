<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeProductRepository extends AbstractFakeRepository implements ProductRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Product);
    }

    public function save(Entity\Product & $product)
    {
    }

    public function create(Entity\Product & $entity)
    {
    }

    public function remove(Entity\Product & $product)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getReturnValue();
    }

    public function getRelatedProducts(array $products, $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    public function getRelatedProductsByIds(array $productIds, $tagIds = [], $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getProductsByTagId($tagId, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getProductsByIds(array $productIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllProductsByIds(array $productIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getRandomProducts($limit)
    {
        return $this->getReturnValueAsArray();
    }

    public function loadProductTags(array & $products)
    {
    }
}
