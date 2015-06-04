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
        $this->optionRepository = $this->repository()->getOption();
    }

    private function setupOption()
    {
        $option = $this->getDummyOption();

        $this->optionRepository->create($option);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $option;
    }

    public function testCRUD()
    {
        $option = $this->setupOption();
        $option->setName('new name');

        $this->assertSame(null, $option->getUpdated());
        $this->optionRepository->save($option);
        $this->assertTrue($option->getUpdated() instanceof \DateTime);

        $this->optionRepository->remove($option);
        $this->assertSame(null, $option->getId());
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

    public function testGetAllOptions()
    {
        $this->setupOption();

        $options = $this->optionRepository->getAllOptions('ze');

        $this->assertSame(1, $options[0]->getId());
    }
}
