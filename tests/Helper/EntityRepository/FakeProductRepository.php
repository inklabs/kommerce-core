<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

class FakeProductRepository extends AbstractFakeRepository implements ProductRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Product);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneBySku($sku)
    {
        return $this->getReturnValue();
    }

    public function getRelatedProducts($products, $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    public function getRelatedProductsByIds(array $productIds, $tagIds = [], $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    public function getProductsByTag(Tag $tag, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getProductsByTagId($tagId, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getProductsByIds(array $productIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllProducts($queryString = null, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllProductsByIds(array $productIds, Pagination & $pagination = null)
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
