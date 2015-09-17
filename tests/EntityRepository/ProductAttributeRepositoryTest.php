<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class ProductAttributeRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:ProductAttribute',
        'kommerce:Product',
    ];

    /** @var ProductAttributeRepositoryInterface */
    protected $productAttributeRepository;

    public function setUp()
    {
        $this->productAttributeRepository = $this->repository()->getProductAttributeRepository();
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

        $productAttribute = $this->productAttributeRepository
            ->find(1);

        $productAttribute->getAttribute()->getCreated();
        $productAttribute->getAttributeValue()->getCreated();

        $this->assertTrue($productAttribute instanceof Entity\ProductAttribute);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}