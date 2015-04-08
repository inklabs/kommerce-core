<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\tests\Helper as Helper;

class AttributeValueTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\AttributeValue */
    protected $mockAttributeValueRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    public function setUp()
    {
        $this->mockAttributeValueRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\AttributeValue');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
    }

    private function setupAttributeValue()
    {
        $attributeValue = $this->getDummyAttributeValue();

        $this->entityManager->persist($attributeValue);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $attributeValue;
    }

    public function testFind()
    {
        $attributeValue = $this->getDummyAttributeValue();

        $this->mockAttributeValueRepository
            ->shouldReceive('find')
            ->andReturn($attributeValue);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockAttributeValueRepository);

        $attributeValueService = new AttributeValue($this->mockEntityManager);

        $attributeValue = $attributeValueService->find(1);
        $this->assertTrue($attributeValue instanceof View\AttributeValue);
    }

    public function testGetAttributeValuesByIds()
    {
        $this->mockAttributeValueRepository
            ->shouldReceive('getAttributeValuesByIds')
            ->andReturn([new Entity\AttributeValue]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockAttributeValueRepository);

        $attributeValueService = new AttributeValue($this->mockEntityManager);

        $attributeValues = $attributeValueService->getAttributeValuesByIds([1]);
        $this->assertTrue($attributeValues[0] instanceof View\AttributeValue);
    }
}
