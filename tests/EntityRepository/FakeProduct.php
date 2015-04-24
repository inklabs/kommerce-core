<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\ProductInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeProduct extends Helper\AbstractFake implements ProductInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Product);
    }

    /**
     * @param int $id
     * @return Entity\Product
     */
    public function find($id)
    {
        return $this->getReturnValue();
    }

    /**
     * @param Entity\Product[] $products
     * @return Entity\Product[]
     */
    public function getRelatedProducts(array $products, $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return Entity\Product[]
     */
    public function getRelatedProductsByIds($productIds, $tagIds = null, $limit = 12)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return Entity\Product[]
     */
    public function getProductsByTag(Entity\Tag $tag, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return Entity\Product[]
     */
    public function getProductsByTagId($tagId, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return Entity\Product[]
     */
    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return Entity\Product[]
     */
    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return Entity\Product[]
     */
    public function getAllProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @return View\Product[]
     */
    public function getRandomProducts($limit)
    {
        return $this->getReturnValueAsArray();
    }
}
