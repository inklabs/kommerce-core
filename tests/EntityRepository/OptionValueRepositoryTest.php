<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\tests\Helper;

class OptionValueRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionValue',
    ];

    /** @var OptionValueRepositoryInterface */
    protected $optionValueRepository;

    public function setUp()
    {
        $this->optionValueRepository = $this->getRepositoryFactory()->getOptionValueRepository();
    }

    private function setupOptionValue()
    {
        $option = $this->getDummyOption();
        $optionValue = $this->getDummyOptionValue($option);

        $this->entityManager->persist($option);

        $this->optionValueRepository->create($optionValue);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $optionValue;
    }

    public function testCRUD()
    {
        $option = $this->getDummyOption();
        $this->entityManager->persist($option);
        $this->entityManager->flush();

        $optionValue = $this->getDummyOptionValue($option);
        $this->optionValueRepository->create($optionValue);
        $this->assertSame(1, $optionValue->getId());

        $optionValue->setName('New Name');
        $this->assertSame(null, $optionValue->getUpdated());

        $this->optionValueRepository->update($optionValue);
        $this->assertTrue($optionValue->getUpdated() instanceof \DateTime);

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
