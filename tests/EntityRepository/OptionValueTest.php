<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class OptionValueTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionValue',
    ];

    /** @var OptionValueInterface */
    protected $optionValueRepository;

    public function setUp()
    {
        $this->optionValueRepository = $this->entityManager->getRepository('kommerce:OptionValue');
    }

    private function setupOptionValue()
    {
        $option = $this->getDummyOption();
        $optionValueProduct = $this->getDummyOptionValue($option);

        $this->entityManager->persist($option);
        $this->entityManager->persist($optionValueProduct);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValue = $this->optionValueRepository->find(1);

        $optionValue->getOption()->getCreated();

        $this->assertTrue($optionValue instanceof Entity\OptionValue);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValues = $this->optionValueRepository->getAllOptionValuesByIds([1]);

        $optionValues[0]->getOption()->getCreated();

        $this->assertTrue($optionValues[0] instanceof Entity\OptionValue);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
