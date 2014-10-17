<?php
namespace inklabs\kommerce\Service;

class Pricing
{
    protected $pricing;

    public function __construct()
    {
        $entityManager = Kommerce::factory()->getEntityManager();
        $catalogPromotions = $entityManager->getRepository('inklabs\kommerce\Entity\CatalogPromotion')->findAll();

        $this->pricing = new \inklabs\kommerce\Pricing;
        $this->pricing->addCatalogPromotions($catalogPromotions);
    }

    public function getPricing()
    {
        return $this->pricing;
    }
}
