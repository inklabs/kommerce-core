<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\tests\Helper;

class OptionRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionProduct',
        'kommerce:OptionValue',
        'kommerce:Product',
        'kommerce:Tag',
    ];

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    public function setUp()
    {
        $this->optionRepository = $this->getRepositoryFactory()->getOptionRepository();
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
        $this->optionRepository->update($option);
        $this->assertTrue($option->getUpdated() instanceof \DateTime);

        $this->optionRepository->delete($option);
        $this->assertSame(null, $option->getId());
    }

    public function testFind()
    {
        $this->setupOption();

        $this->setCountLogger();

        $option = $this->optionRepository->findOneById(1);

        $option->getOptionProducts()->toArray();
        $option->getOptionValues()->toArray();
        $option->getTags()->toArray();

        $this->assertTrue($option instanceof Option);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $options = $this->optionRepository->getAllOptionsByIds([1]);

        $this->assertTrue($options[0] instanceof Option);
    }

    public function testGetAllOptions()
    {
        $this->setupOption();

        $options = $this->optionRepository->getAllOptions('ze');

        $this->assertSame(1, $options[0]->getId());
    }
}
