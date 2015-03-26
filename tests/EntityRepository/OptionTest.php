<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class OptionTest extends Helper\DoctrineTestCase
{
    /**
     * @return Option
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Option');
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

        $option = $this->getRepository()
            ->find(1);

        $option->getOptionValues()->toArray();
        $option->getTags()->toArray();

        $this->assertTrue($option instanceof Entity\Option);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $this->setupOption();

        $options = $this->getRepository()
            ->getAllOptionsByIds([1]);

        $this->assertSame(1, $options[0]->getId());
    }
}
