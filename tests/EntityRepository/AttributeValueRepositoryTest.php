<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\tests\Helper;

class AttributeValueRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:ProductAttribute',
        'kommerce:Product',
    ];

    /** @var AttributeValueRepositoryInterface */
    protected $attributeValueRepository;

    public function setUp()
    {
        parent::setUp();
        $this->attributeValueRepository = $this->getRepositoryFactory()->getAttributeValueRepository();
    }

    private function setupAttributeValue()
    {
        $attributeValue = $this->dummyData->getAttributeValue();

        $attribute = $this->dummyData->getAttribute();
        $attribute->addAttributeValue($attributeValue);

        $this->entityManager->persist($attribute);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFindOneById()
    {
        $this->setupAttributeValue();

        $this->setCountLogger();

        $attributeValue = $this->attributeValueRepository->findOneById(1);

        $attributeValue->getAttribute()->getCreated();
        $attributeValue->getProductAttributes()->toArray();

        $this->assertTrue($attributeValue instanceof AttributeValue);
        $this->assertSame(2, $this->getTotalQueries());
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     * @expectedExceptionMessage AttributeValue not found
     */
    public function testFindOneByIdThrowsException()
    {
        $this->attributeValueRepository->findOneById(1);
    }

    public function testGetAttributeValuesByIds()
    {
        $this->setupAttributeValue();

        $attributeValues = $this->attributeValueRepository->getAttributeValuesByIds([1]);

        $this->assertSame(1, count($attributeValues));
        $this->assertSame(1, $attributeValues[0]->getId());
    }
}
