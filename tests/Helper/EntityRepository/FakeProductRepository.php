<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

/**
 * @method Product findOneById($id)
 */
class FakeProductRepository extends AbstractFakeRepository implements ProductRepositoryInterface
{
    protected $entityName = 'Product';

    /** @var Product[] */
    protected $entities = [];

    public function __construct()
    {
        $this->setReturnValue(new Product);
    }

    public function findOneBySku($sku)
    {
        foreach ($this->entities as $entity) {
            if ($entity->getSku() === $sku) {
                return $entity;
            }
        }
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
