<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class OptionValueTest extends Helper\DoctrineTestCase
{
    /**
     * @return OptionValue
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OptionValue');
    }

    private function setupOptionValue()
    {
        $product = $this->getDummyProduct();

        $optionValue = $this->getDummyOptionValue();
        $optionValue->setProduct($product);

        $option = $this->getDummyOption();
        $option->addOptionValue($optionValue);

        $this->entityManager->persist($option);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $option = $this->getRepository()
            ->find(1);

        $option->getProduct()->getCreated();
        $option->getOption()->getCreated();

        $this->assertTrue($option instanceof Entity\OptionValue);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValues = $this->getRepository()
            ->getAllOptionValuesByIds([1]);

        $this->assertTrue($optionValues[0] instanceof Entity\OptionValue);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
