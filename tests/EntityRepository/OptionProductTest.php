<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class OptionProductTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionProduct',
        'kommerce:Product',
    ];

    /**
     * @return OptionProduct
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OptionProduct');
    }

    private function setupOptionProduct()
    {
        $product = $this->getDummyProduct();
        $option = $this->getDummyOption();
        $optionProduct = $this->getDummyOptionProduct($option, $product);

        $this->entityManager->persist($option);
        $this->entityManager->persist($optionProduct);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOptionProduct();

        $this->setCountLogger();

        $optionProduct = $this->getRepository()
            ->find(1);

        $optionProduct->getProduct()->getCreated();
        $optionProduct->getOption()->getCreated();

        $this->assertTrue($optionProduct instanceof Entity\OptionProduct);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionProduct();

        $this->setCountLogger();

        $optionProducts = $this->getRepository()
            ->getAllOptionProductsByIds([1]);

        $optionProducts[0]->getProduct()->getCreated();
        $optionProducts[0]->getOption()->getCreated();

        $this->assertTrue($optionProducts[0] instanceof Entity\OptionProduct);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
