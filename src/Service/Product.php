<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Product extends Lib\EntityManager
{
    private $pricing;

    public function __construct(EntityManager $entityManager, Pricing $pricing)
    {
        $this->setEntityManager($entityManager);
        $this->pricing = $pricing;
    }

    public function find($id)
    {
        $entityProduct = $this->entityManager->getRepository('inklabs\kommerce\Entity\Product')->find($id);

        if ($entityProduct === null or ! $entityProduct->getIsActive()) {
            return null;
        }

        return Entity\View\Product::factory($entityProduct)
            ->withAllData($this->pricing)
            ->export();
    }

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

        $qb = $this->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id NOT IN (:productId)')
                ->setParameter('productId', $productIds)
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND(:rand) as HIDDEN rand')
                ->setParameter('rand', array_sum($productIds))
            ->orderBy('rand')
            ->setMaxResults($limit);

        if (! empty($tagIds)) {
            $query = $query
                ->innerJoin('product.tags', 'tag')
                ->andWhere('tag.id IN (:tagIds)')
                    ->setParameter('tagIds', $tagIds);
        }

        $products = $query->findAll();

        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = Entity\View\Product::factory($product)
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }

    public function getProductsByTag(Entity\View\Tag $tag, Entity\Pagination & $pagination = null)
    {
        $qb = $this->createQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->innerJoin('product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('tagId', $tag->id)
            ->paginate($pagination)
            ->findAll();

        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = Entity\View\Product::factory($product)
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->createQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id IN (:productIds)')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('productIds', $productIds)
            ->paginate($pagination)
            ->findAll();

        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = Entity\View\Product::factory($product)
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }

    public function getRandomProducts($limit)
    {
        $qb = $this->createQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->findAll();

        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = Entity\View\Product::factory($product)
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }
}
