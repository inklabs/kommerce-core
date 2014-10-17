<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class Pricing
{
    protected $pricing;

    public function __construct()
    {
        $entityManager = Kommerce::factory()->getEntityManager();
        $catalogPromotions = $entityManager->getRepository('inklabs\kommerce\Entity\CatalogPromotion')->findAll();

        $this->pricing = new Entity\Pricing;
        $this->pricing->addCatalogPromotions($catalogPromotions);
    }

    public function getPricing()
    {
        return $this->pricing;
    }
}
