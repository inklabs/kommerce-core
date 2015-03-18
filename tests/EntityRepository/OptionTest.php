<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class OptionTest extends Helper\DoctrineTestCase
{
    /**
     * @return Order
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Option');
    }

    public function setUp()
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
        /* @var Entity\Option $option */
        $option = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $option->getId());
    }
}
