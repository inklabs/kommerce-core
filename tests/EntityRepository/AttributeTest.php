<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class AttributeTest extends Helper\DoctrineTestCase
{
    /**
     * @return Attribute
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Attribute');
    }

    private function setupAttribute()
    {
        $attribute = $this->getDummyAttribute();

        $this->entityManager->persist($attribute);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupAttribute();

        $this->setCountLogger();

        $attribute = $this->getRepository()
            ->find(1);

        $attribute->getAttributeValues()->toArray();
        $attribute->getProductAttributes()->toArray();

        $this->assertTrue($attribute instanceof Entity\Attribute);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }
}
