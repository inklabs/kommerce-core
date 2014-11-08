<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Product extends Lib\EntityManager
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function find($id)
    {
        $product = $this->entityManager->getRepository('inklabs\kommerce\Entity\Product')->find($id);

        if ($product === null or ! $product->getIsActive()) {
            return null;
        }

        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

        $productQuantityDiscounts = $product->getProductQuantityDiscounts();
        $pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        // $price = $pricing->getPrice($product, 1);
        // $product->setPrice($price);

        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $price = $pricing->getPrice($product, $productQuantityDiscount->getQuantity());
            $productQuantityDiscount->setPrice($price);
        }

        return $product;
    }

    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }

        $productIds = [];
        $tagIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->getId();
            foreach ($product->getTags() as $tag) {
                $tagIds[] = $tag->getId();
            }
        }

        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

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

        $relatedProducts = $query->findAll();

        // foreach ($relatedProducts as $relatedProduct) {
        //     $price = $pricing->getPrice($relatedProduct, 1);
        //     $relatedProduct->setPrice($price);
        // }

        return $relatedProducts;
    }

    public function getProductsByTag($tag, Entity\Pagination & $pagination = null)
    {
        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

        $qb = $this->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->innerJoin('product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('tagId', $tag->getId())
            ->paginate($pagination);

        $tagProducts = $query->findAll();

        // foreach ($tagProducts as $tagProduct) {
        //     $price = $pricing->getPrice($tagProduct, 1);
        //     $tagProduct->setPrice($price);
        // }

        return $tagProducts;
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

        $qb = $this->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id IN (:productIds)')
            ->productActiveAndVisible()
            ->productAvailable()
            ->setParameter('productIds', $productIds)
            ->paginate($pagination);

        $products = $query->findAll();

        // foreach ($products as $product) {
        //     $price = $pricing->getPrice($product, 1);
        //     $product->setPrice($price);
        // }

        return $products;
    }

    public function getRandomProducts($limit)
    {
        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

        $qb = $this->createQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->productActiveAndVisible()
            ->productAvailable()
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->findAll();

        // foreach ($products as $product) {
        //     $price = $pricing->getPrice($product, 1);
        //     $product->setPrice($price);
        // }

        return $products;
    }
}
