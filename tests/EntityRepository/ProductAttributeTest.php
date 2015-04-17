<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class ProductAttributeTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:ProductAttribute',
        'kommerce:Product',
    ];

    /**
     * @return ProductAttribute
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:ProductAttribute');
    }

    private function setupProductAttribute()
    {
        $attributeValue = $this->getDummyAttributeValue();

        $attribute = $this->getDummyAttribute();
        $attribute->addAttributeValue($attributeValue);

        $productAttribute = $this->getDummyProductAttribute();
        $productAttribute->setAttribute($attribute);
        $productAttribute->setAttributeValue($attributeValue);

        $this->entityManager->persist($attribute);
        $this->entityManager->persist($productAttribute);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupProductAttribute();

        $this->setCountLogger();

        $productAttribute = $this->getRepository()
            ->find(1);

        $productAttribute->getAttribute()->getCreated();
        $productAttribute->getAttributeValue()->getCreated();

        $this->assertTrue($productAttribute instanceof Entity\ProductAttribute);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
