<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

// TODO: Remove. The responsibility for this entity is cascaded in the Attribute Repository
class AttributeValueRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        ProductAttribute::class,
        Product::class,
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
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue($attribute);

        $this->entityManager->persist($attribute);
        $this->entityManager->persist($attributeValue);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $attributeValue;
    }

//    public function testCRUD()
//    {
//        $attribute = $this->dummyData->getAttribute();
//        $this->entityManager->persist($attribute);
//        $this->entityManager->flush();
//        $this->entityManager->clear();
//
//        $this->executeRepositoryCRUD(
//            $this->attributeValueRepository,
//            $this->dummyData->getAttributeValue($attribute)
//        );
//    }

    public function testFindOneById()
    {
        $originalAttributeValue = $this->setupAttributeValue();

        $this->setCountLogger();

        $attributeValue = $this->attributeValueRepository->findOneById($originalAttributeValue->getId());

        $attributeValue->getAttribute()->getCreated();
        $this->visitElements($attributeValue->getProductAttributes());

        $this->assertEquals($originalAttributeValue->getId(), $attributeValue->getId());
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'AttributeValue not found'
        );

        $this->attributeValueRepository->findOneById($this->dummyData->getId());
    }

    public function testGetAttributeValuesByIds()
    {
        $originalAttributeValue = $this->setupAttributeValue();

        $attributeValues = $this->attributeValueRepository->getAttributeValuesByIds([
            $originalAttributeValue->getId()
        ]);

        $this->assertSame(1, count($attributeValues));
        $this->assertEquals($originalAttributeValue->getId(), $attributeValues[0]->getId());
    }
}
