<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class AttributeRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        ProductAttribute::class,
        Product::class,
    ];

    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->attributeRepository = $this->getRepositoryFactory()->getAttributeRepository();
    }

    private function setupAttribute()
    {
        $product = $this->dummyData->getProduct();
        $attribute = $this->dummyData->getAttribute();
        $attributeValue1 = $this->dummyData->getAttributeValue($attribute);
        $attributeValue2 = $this->dummyData->getAttributeValue($attribute);
        $productAttribute = $this->dummyData->getProductAttribute($product, $attribute, $attributeValue2);

        $this->entityManager->persist($product);
        $this->entityManager->persist($attribute);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $attribute;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->attributeRepository,
            $this->dummyData->getAttribute()
        );
    }

    public function testFindOneById()
    {
        $originalAttribute = $this->setupAttribute();
        $this->setCountLogger();

        $attribute = $this->attributeRepository->findOneById(
            $originalAttribute->getId()
        );

        $this->visitElements($attribute->getAttributeValues());
        $this->visitElements($attribute->getProductAttributes());

        $this->assertEquals($originalAttribute->getId(), $attribute->getId());
        $this->assertSame(3, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Attribute not found'
        );

        $this->attributeRepository->findOneById(
            $this->dummyData->getId()
        );
    }
}
