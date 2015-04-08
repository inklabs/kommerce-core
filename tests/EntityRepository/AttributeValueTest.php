<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class AttributeValueTest extends Helper\DoctrineTestCase
{
    /**
     * @return AttributeValue
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:AttributeValue');
    }

    private function setupAttributeValue()
    {
        $attributeValue = $this->getDummyAttributeValue();

        $attribute = $this->getDummyAttribute();
        $attribute->addAttributeValue($attributeValue);

        $this->entityManager->persist($attribute);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupAttributeValue();

        $this->setCountLogger();

        $attributeValue = $this->getRepository()
            ->find(1);

        $attributeValue->getAttribute()->getCreated();
        $attributeValue->getProductAttributes()->toArray();

        $this->assertTrue($attributeValue instanceof Entity\AttributeValue);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAttributeValuesByIds()
    {
        $this->setupAttributeValue();

        $attributeValues = $this->getRepository()
            ->getAttributeValuesByIds([1]);

        $this->assertSame(1, count($attributeValues));
        $this->assertSame(1, $attributeValues[0]->getId());
    }
}
