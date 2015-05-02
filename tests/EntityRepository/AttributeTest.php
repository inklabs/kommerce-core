<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class AttributeTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:ProductAttribute',
        'kommerce:Product',
    ];

    /** @var AttributeInterface */
    protected $attributeRepository;

    public function setUp()
    {
        $this->attributeRepository = $this->getAttributeRepository();
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

        $attribute = $this->attributeRepository->find(1);

        $attribute->getAttributeValues()->toArray();
        $attribute->getProductAttributes()->toArray();

        $this->assertTrue($attribute instanceof Entity\Attribute);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }
}
