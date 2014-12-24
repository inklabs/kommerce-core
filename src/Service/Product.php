<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Product extends Lib\EntityManager
{
    /* @var Pricing */
    private $pricing;

    /* @var EntityRepository\Product */
    private $productRepository;

    public function __construct(EntityManager $entityManager, Pricing $pricing)
    {
        $this->setEntityManager($entityManager);
        $this->pricing = $pricing;
        $this->productRepository = $entityManager->getRepository('kommerce:Product');
    }

    /**
     * @return Entity\View\Product|null
     */
    public function find($id)
    {
        $entityProduct = $this->productRepository->find($id);

        if ($entityProduct === null or ! $entityProduct->getIsActive()) {
            return null;
        }

        return $entityProduct->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @return Entity\View\Product[]
     */
    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }

        $productIds = [];
        $tagIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->id;
            foreach ($product->tags as $tag) {
                $tagIds[] = $tag->id;
            }
        }

        $products = $this->productRepository
            ->getRelatedProductsByIds($productIds, $tagIds, $limit);

        return $this->getViewProductsWithPrice($products);
    }

    /**
     * @return Entity\View\Product[]
     */
    public function getProductsByTag(Entity\View\Tag $tag, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getProductsByTagId($tag->id);

        return $this->getViewProductsWithPrice($products);
    }

    /**
     * @return Entity\View\Product[]
     */
    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getProductsByIds($productIds);

        return $this->getViewProductsWithPrice($products);
    }

    /**
     * @return Entity\View\Product[]
     */
    public function getRandomProducts($limit)
    {
        $products = $this->productRepository
            ->getRandomProducts($limit);

        return $this->getViewProductsWithPrice($products);
    }

    /**
     * @param Entity\Product[] $products
     * @return Entity\View\Product[]
     */
    private function getViewProductsWithPrice($products)
    {
        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = $product->getView()
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }
}
