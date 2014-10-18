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
}
