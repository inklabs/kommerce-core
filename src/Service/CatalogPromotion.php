<?php
namespace inklabs\kommerce\Service;

class CatalogPromotion extends EntityManager
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function findAll()
    {
        $catalogPromotions = $this->entityManager->getRepository('inklabs\kommerce\Entity\CatalogPromotion')->findAll();
        return $catalogPromotions;
    }
}
