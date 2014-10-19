<?php
namespace inklabs\kommerce\Service;

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

        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
            ->where('product.id <> :productId');

        $parameters = [
            'productId' => $product->getId()
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
        // ->where('product.id', 'NOT IN', $product_ids)
        // ->where('product.visible', '=', 1)
        // ->where_open()
        //     ->where('product.require_inventory', '=', 1)
        //     ->where('product.quantity', '>', 0)
        //     ->or_where_open()
        //         ->where('product.require_inventory', '=', 0)
        //     ->or_where_close()
        // ->where_close()
        // ->where('product.active', '=', 1)
        // ->group_by('product.id')
        // ->order_by($order_by)
        // ->limit($limit)
        // ->find_all()

        $relatedProducts = $query->getQuery()->getResult();

        foreach ($relatedProducts as $relatedProduct) {
            $price = $pricing->getPrice($relatedProduct, 1);
            $relatedProduct->setPriceObj($price);
        }

        return $relatedProducts;
    }
}
