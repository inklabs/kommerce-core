<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\ProductInterface;
use inklabs\kommerce\Entity;

class FakeProduct extends AbstractFake implements ProductInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Product);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getRelatedProducts(array $products, $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    public function getRelatedProductsByIds($productIds, $tagIds = null, $limit = 12)
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

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getRandomProducts($limit)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Entity\Product & $entity)
    {
    }

    public function save(Entity\Product & $product)
    {
    }

    public function persist(Entity\Product & $product)
    {
    }
}
