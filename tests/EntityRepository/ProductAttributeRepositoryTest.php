<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\tests\Helper;

class ProductAttributeRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        ProductAttribute::class,
        Product::class,
    ];

    /** @var ProductAttributeRepositoryInterface */
    protected $productAttributeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->productAttributeRepository = $this->getRepositoryFactory()->getProductAttributeRepository();
    }

    private function setupProductAttribute()
    {
        $attributeValue = $this->dummyData->getAttributeValue();

        $attribute = $this->dummyData->getAttribute();
        $attribute->addAttributeValue($attributeValue);

        $productAttribute = $this->dummyData->getProductAttribute();
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

        $productAttribute = $this->productAttributeRepository->findOneById(1);

        $productAttribute->getAttribute()->getCreated();
        $productAttribute->getAttributeValue()->getCreated();

        $this->assertTrue($productAttribute instanceof ProductAttribute);
        $this->assertSame(1, $this->getTotalQueries());
    }
}
