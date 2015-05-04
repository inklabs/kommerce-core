<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class TextOptionTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:TextOption',
        'kommerce:Tag',
    ];

    /** @var TextOptionInterface */
    protected $textOptionRepository;

    public function setUp()
    {
        $this->textOptionRepository = $this->repository()->getTextOption();
    }

    private function setupOption()
    {
        $textOption = $this->getDummyTextOption();

        $this->entityManager->persist($textOption);
        $this->entityManager->flush();
        $this->entityManager->clear();
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
