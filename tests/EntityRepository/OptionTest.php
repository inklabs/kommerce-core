<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class OptionTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionProduct',
        'kommerce:OptionValue',
        'kommerce:Product',
        'kommerce:Tag',
    ];

    /** @var OptionInterface */
    protected $optionRepository;

    public function setUp()
    {
        $this->optionRepository = $this->getOptionRepository();
    }

    private function setupOption()
    {
        $option = $this->getDummyOption();

        $this->entityManager->persist($option);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOption();

        $this->setCountLogger();

        $option = $this->optionRepository->find(1);

        $option->getOptionProducts()->toArray();
        $option->getOptionValues()->toArray();
        $option->getTags()->toArray();

        $this->assertTrue($option instanceof Entity\Option);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $options = $this->optionRepository->getAllOptionsByIds([1]);

        $this->assertTrue($options[0] instanceof Entity\Option);
    }
}
