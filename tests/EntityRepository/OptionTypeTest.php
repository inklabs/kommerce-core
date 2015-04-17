<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class OptionTypeTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:OptionType\AbstractOptionType',
        'kommerce:OptionValue\AbstractOptionValue',
        'kommerce:Tag',
    ];

    /**
     * @return OptionType
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OptionType\AbstractOptionType');
    }

    private function setupOption()
    {
        $optionType = $this->getDummyOptionTypeProduct();

        $this->entityManager->persist($optionType);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOption();

        $this->setCountLogger();

        $optionType = $this->getRepository()
            ->find(1);

        $optionType->getOptionValues()->toArray();
        $optionType->getTags()->toArray();

        $this->assertTrue($optionType instanceof Entity\OptionType\AbstractOptionType);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $optionTypes = $this->getRepository()
            ->getAllOptionsByIds([1]);

        $this->assertSame(1, $optionTypes[0]->getId());
    }
}
