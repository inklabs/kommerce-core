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
        $option = new Entity\Option;
        $option->setName('Size');
        $option->setType(Entity\Option::TYPE_RADIO);
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);

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

        $option->getProducts()->toArray();
        $option->getTags()->toArray();

        $this->assertTrue($option instanceof Entity\Option);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }
}
