<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    /**
     * @return CatalogPromotion
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:CatalogPromotion');
    }

    public function setUp()
    {
        $tag = new Entity\Tag;
        $tag->setName('Tag');

        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setType(Entity\Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);
        $catalogPromotion->setTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\CatalogPromotion $catalogPromotion */
        $catalogPromotion = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $catalogPromotion->getId());
        $this->assertSame(1, $catalogPromotion->getTag()->getId());
    }
}
