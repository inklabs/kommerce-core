<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class OptionValueTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:OptionType\AbstractOptionType',
        'kommerce:OptionValue\AbstractOptionValue',
        'kommerce:Product',
    ];

    /**
     * @return OptionValue
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OptionValue\AbstractOptionValue');
    }

    private function setupOptionValue()
    {
        $product = $this->getDummyProduct();
        $optionTypeProduct = $this->getDummyOptionTypeProduct();
        $optionValueProduct = $this->getDummyOptionValueProduct($optionTypeProduct, $product);

        $this->entityManager->persist($optionTypeProduct);
        $this->entityManager->persist($optionValueProduct);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValue = $this->getRepository()
            ->find(1);

        $optionValue->getProduct()->getCreated();
        $optionValue->getOptionType()->getCreated();

        $this->assertTrue($optionValue instanceof Entity\OptionValue\AbstractOptionValue);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionValue();

        $this->setCountLogger();

        $optionValues = $this->getRepository()
            ->getAllOptionValuesByIds([1]);

        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
