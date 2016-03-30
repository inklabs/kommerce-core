<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper;

class TextOptionRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        TextOption::class,
        Tag::class,
    ];

    /** @var TextOptionRepositoryInterface */
    protected $textOptionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->textOptionRepository = $this->getRepositoryFactory()->getTextOptionRepository();
    }

    private function setupOption()
    {
        $textOption = $this->dummyData->getTextOption();

        $this->entityManager->persist($textOption);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $textOption = $this->dummyData->getTextOption();

        $this->textOptionRepository->create($textOption);
        $this->assertSame(1, $textOption->getId());

        $textOption->setName('New Name');
        $this->assertSame(null, $textOption->getUpdated());

        $this->textOptionRepository->update($textOption);
        $this->assertTrue($textOption->getUpdated() instanceof DateTime);

        $this->textOptionRepository->delete($textOption);
        $this->assertSame(null, $textOption->getId());
    }

    public function testFind()
    {
        $this->setupOption();

        $this->setCountLogger();

        $textOption = $this->textOptionRepository->findOneById(1);

        $textOption->getTags()->toArray();

        $this->assertTrue($textOption instanceof TextOption);
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds([1]);

        $this->assertTrue($textOptions[0] instanceof TextOption);
    }
}
