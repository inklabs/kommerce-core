<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OptionValueRepositoryTest extends EntityRepositoryTestCase
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

        $this->executeRepositoryCRUD(
            $this->optionValueRepository,
            $this->dummyData->getOptionValue($option)
        );
    }

    public function testFind()
    {
        $originalOptionValue = $this->setupOptionValue();
        $this->setCountLogger();

        $optionValue = $this->optionValueRepository->findOneById(
            $originalOptionValue->getId()
        );

        $optionValue->getOption()->getCreated();

        $this->assertEquals($originalOptionValue->getId(), $optionValue->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $originalOptionValue = $this->setupOptionValue();
        $this->setCountLogger();

        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds([
            $originalOptionValue->getId()
        ]);

        $optionValues[0]->getOption()->getCreated();

        $this->assertEquals($originalOptionValue->getId(), $optionValues[0]->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }
}
