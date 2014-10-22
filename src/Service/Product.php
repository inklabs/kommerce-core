<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class Product extends EntityManager
{
    public function find($id)
    {
        $pricingService = new Pricing($this->entityManager);
        $pricing = $pricingService->getPricing();

        $product = $this->entityManager->getRepository('inklabs\kommerce\Entity\Product')->find($id);

        if ($product === null or ! $product->getIsActive()) {
            return null;
        }

        $price = $pricing->getPrice($product, 1);
        $product->setPriceObj($price);

        return $product;
    }

    public function getRelatedProducts($product, $limit = 12)
    {
        $pricingService = new Pricing($this->entityManager);
        $pricing = $pricingService->getPricing();

        $qb = $this->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id <> :productId')
                ->setParameter('productId', $product->getId())
            ->productActiveVisible()
            ->productAvailable()
            ->addSelect('RAND(:rand) as HIDDEN rand')
                ->setParameter('rand', $product->getId())
            ->orderBy('rand')
            ->setMaxResults($limit);

        $tags = $product->getTags();
        if (! empty($tags)) {
            $tagIds = [];
            foreach ($tags as $tag) {
                $tagIds[] = $tag->getId();
            }

            $query = $query
                ->innerJoin('product.tags', 'tag')
                ->andWhere('tag.id IN (:tagIds)')
                    ->setParameter('tagIds', $tagIds);
        }

        $relatedProducts = $query->findAll();

        foreach ($relatedProducts as $relatedProduct) {
            $price = $pricing->getPrice($relatedProduct, 1);
            $relatedProduct->setPriceObj($price);
        }

        return $relatedProducts;
    }

    public function getProductsByTag($tag, Entity\Pagination & $pagination = null)
    {
        $pricingService = new Pricing($this->entityManager);
        $pricing = $pricingService->getPricing();

        $qb = $this->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->innerJoin('product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->productActiveVisible()
            ->productAvailable()
            ->setParameter('tagId', $tag->getId())
            ->paginate($pagination);

        $tagProducts = $query->findAll();

        foreach ($tagProducts as $tagProduct) {
            $price = $pricing->getPrice($tagProduct, 1);
            $tagProduct->setPriceObj($price);
        }

        return $tagProducts;
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $pricingService = new Pricing($this->entityManager);
        $pricing = $pricingService->getPricing();

        $qb = $this->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id IN (:productIds)')
            ->productActiveVisible()
            ->productAvailable()
            ->setParameter('productIds', $productIds)
            ->paginate($pagination);

        $products = $query->findAll();

        foreach ($products as $product) {
            $price = $pricing->getPrice($product, 1);
            $product->setPriceObj($price);
        }

        return $products;
    }

    public function getRandomProducts($limit)
    {
        $pricingService = new Pricing($this->entityManager);
        $pricing = $pricingService->getPricing();

        $qb = $this->createQueryBuilder();

        $products = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->productActiveVisible()
            ->productAvailable()
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->findAll();

        foreach ($products as $product) {
            $price = $pricing->getPrice($product, 1);
            $product->setPriceObj($price);
        }

        return $products;
    }
}
