<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class TextOptionRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:TextOption',
        'kommerce:Tag',
    ];

    /** @var TextOptionRepositoryInterface */
    protected $textOptionRepository;

    public function setUp()
    {
        $this->textOptionRepository = $this->repository()->getTextOptionRepository();
    }

    private function setupOption()
    {
        $textOption = $this->getDummyTextOption();

        $this->entityManager->persist($textOption);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $textOption = $this->getDummyTextOption();

        $this->textOptionRepository->create($textOption);
        $this->assertSame(1, $textOption->getId());

        $textOption->setName('New Name');
        $this->assertSame(null, $textOption->getUpdated());

        $this->textOptionRepository->save($textOption);
        $this->assertTrue($textOption->getUpdated() instanceof \DateTime);

        $this->textOptionRepository->remove($textOption);
        $this->assertSame(null, $textOption->getId());
    }

    public function testFind()
    {
        $this->setupOption();

        $this->setCountLogger();

        $textOption = $this->textOptionRepository->find(1);

        $textOption->getTags()->toArray();

        $this->assertTrue($textOption instanceof Entity\TextOption);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds([1]);

        $this->assertTrue($textOptions[0] instanceof Entity\TextOption);
    }
}
