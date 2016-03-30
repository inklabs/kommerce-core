<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\tests\Helper;

class OptionValueRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionValue::class,
    ];

    /** @var OptionValueRepositoryInterface */
    protected $optionValueRepository;

    public function setUp()
    {
        parent::setUp();
        $this->optionValueRepository = $this->getRepositoryFactory()->getOptionValueRepository();
    }

    private function setupOptionValue()
    {
        $option = $this->dummyData->getOption();
        $optionValue = $this->dummyData->getOptionValue($option);

        $this->entityManager->persist($option);

        $this->optionValueRepository->create($optionValue);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $optionValue;
    }

    public function testCRUD()
    {
        $option = $this->dummyData->getOption();
        $this->entityManager->persist($option);
        $this->entityManager->flush();

        $optionValue = $this->dummyData->getOptionValue($option);
        $this->optionValueRepository->create($optionValue);
        $this->assertSame(1, $optionValue->getId());

        $optionValue->setName('New Name');
        $this->assertSame(null, $optionValue->getUpdated());

        $this->optionValueRepository->update($optionValue);
        $this->assertTrue($optionValue->getUpdated() instanceof DateTime);

        $this->optionValueRepository->delete($optionValue);
        $this->assertSame(null, $optionValue->getId());
    }

    public function testFind()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValue = $this->optionValueRepository->findOneById(1);

        $optionValue->getOption()->getCreated();

        $this->assertTrue($optionValue instanceof OptionValue);
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds([1]);

        $optionValues[0]->getOption()->getCreated();

        $this->assertTrue($optionValues[0] instanceof OptionValue);
        $this->assertSame(1, $this->getTotalQueries());
    }
}
