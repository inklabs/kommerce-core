<?php
namespace inklabs\kommerce\Service;

class Product extends EntityManager
{
    use Common;

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

        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id <> :productId')
            ->andWhere('product.isActive = true')
            ->andWhere('product.isVisible = true')
            ->andWhere('(
                product.isInventoryRequired = true
                AND product.quantity > 0
            ) OR (
                product.isInventoryRequired = false
            )')
            ->addSelect('RAND(:rand) as HIDDEN rand')
            ->orderBy('rand');

        $parameters = [
            'productId' => $product->getId(),
            'rand' => $product->getId(),
        ];

        $tags = $product->getTags();
        if (! empty($tags)) {
            $parameters['tagIds'] = [];
            foreach ($tags as $tag) {
                $parameters['tagIds'][] = $tag->getId();
            }

            $query = $query
                ->innerJoin('product.tags', 'tag')
                ->andWhere('tag.id IN (:tagIds)');
        }

        $query = $query
            ->setMaxResults($limit)
            ->setParameters($parameters);

        // TODO:
        // ->group_by('product.id')
        // ->order_by($order_by)
        // ->limit($limit)
        // ->find_all()

        // print_r([$query->getQuery()->getSql(), $parameters]);exit;

        $relatedProducts = $query->getQuery()->getResult();

        foreach ($relatedProducts as $relatedProduct) {
            $price = $pricing->getPrice($relatedProduct, 1);
            $relatedProduct->setPriceObj($price);
        }

        return $relatedProducts;
    }

    public function getProductsByTag($tag, & $pagination = null)
    {
        $pricingService = new Pricing($this->entityManager);
        $pricing = $pricingService->getPricing();

        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->innerJoin('product.tags', 'tag')
            ->where('tag.id = :tagId')
            ->andWhere('product.isActive = true')
            ->andWhere('product.isVisible = true')
            ->andWhere('(
                product.isInventoryRequired = true
                AND product.quantity > 0
            ) OR (
                product.isInventoryRequired = false
            )')
            ->setParameter('tagId', $tag->getId());

        if ($pagination !== null) {
            $query = $pagination->paginate($query);
        }

        $tagProducts = $query
            ->getQuery()
            ->getResult();

        foreach ($tagProducts as $tagProduct) {
            $price = $pricing->getPrice($tagProduct, 1);
            $tagProduct->setPriceObj($price);
        }

        return $tagProducts;
    }
}
