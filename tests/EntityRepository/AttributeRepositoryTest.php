<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper;

class AttributeRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:ProductAttribute',
        'kommerce:Product',
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
        $attribute = $this->dummyData->getAttribute();

        $this->entityManager->persist($attribute);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $attribute = $this->dummyData->getAttribute();
        $this->attributeRepository->create($attribute);
        $this->assertSame(1, $attribute->getId());

        $attribute->setName('New Name');
        $this->assertSame(null, $attribute->getUpdated());

        $this->attributeRepository->update($attribute);
        $this->assertTrue($attribute->getUpdated() instanceof DateTime);

        $this->attributeRepository->delete($attribute);
        $this->assertSame(null, $attribute->getId());
    }

    public function testFindOneById()
    {
        $this->setupAttribute();

        $this->setCountLogger();

        $attribute = $this->attributeRepository->findOneById(1);

        $attribute->getAttributeValues()->toArray();
        $attribute->getProductAttributes()->toArray();

        $this->assertTrue($attribute instanceof Attribute);
        $this->assertSame(3, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Attribute not found'
        );

        $this->attributeRepository->findOneById(1);
    }
}
