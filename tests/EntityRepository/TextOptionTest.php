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

    /**
     * @return TextOption
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:TextOption');
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

        $textOption = $this->getRepository()
            ->find(1);

        $textOption->getTags()->toArray();

        $this->assertTrue($textOption instanceof Entity\TextOption);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $textOptions = $this->getRepository()
            ->getAllOptionsByIds([1]);

        $this->assertTrue($textOptions[0] instanceof Entity\TextOption);
    }
}
