<?php
namespace inklabs\kommerce\Service;

class Product
{
    public static function find($id)
    {
        $pricingService = new Pricing;
        $pricing = $pricingService->getPricing();

        $entityManager = Kommerce::getInstance()->getEntityManager();
        $product = $entityManager->getRepository('inklabs\kommerce\Entity\Product')->find($id);

        if ($product === null or ! $product->getIsActive()) {
            return null;
        }

        $price = $pricing->getPrice($product, 1);
        $product->setPriceObj($price);

        return $product;
    }
}
