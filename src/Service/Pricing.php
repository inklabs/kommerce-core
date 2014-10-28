<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class Pricing extends EntityManager
{
    protected $pricing;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->loadCatalogPromotions();
    }

    public function loadCatalogPromotions()
    {
        $catalogPromotions = $this->entityManager->getRepository('inklabs\kommerce\Entity\CatalogPromotion')->findAll();

        $this->pricing = new Entity\Pricing;
        $this->pricing->setCatalogPromotions($catalogPromotions);
    }

    public function getPricing()
    {
        return $this->pricing;
    }
}
