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

    /** @var OptionProductInterface */
    protected $optionProductRepository;

    public function setUp()
    {
        $this->optionProductRepository = $this->repository()->getOptionProduct();
    }

    private function setupOptionProduct()
    {
        $product = $this->getDummyProduct();
        $option = $this->getDummyOption();
        $optionProduct = $this->getDummyOptionProduct($option, $product);

        $this->entityManager->persist($option);
        $this->entityManager->persist($product);

        $this->optionProductRepository->create($optionProduct);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $optionProduct;
    }

    public function testFind()
    {
        $this->setupOptionProduct();

        $this->setCountLogger();

        $optionProduct = $this->optionProductRepository->find(1);

        $optionProduct->getProduct()->getCreated();
        $optionProduct->getOption()->getCreated();

        $this->assertTrue($optionProduct instanceof Entity\OptionProduct);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionProduct();

        $this->setCountLogger();

        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds([1]);

        $optionProducts[0]->getProduct()->getCreated();
        $optionProducts[0]->getOption()->getCreated();

        $this->assertTrue($optionProducts[0] instanceof Entity\OptionProduct);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testSave()
    {
        $optionProduct = $this->setupOptionProduct();
        $optionProduct->setSortOrder(5);

        $this->assertSame(null, $optionProduct->getUpdated());
        $this->optionProductRepository->save($optionProduct);
        $this->assertTrue($optionProduct->getUpdated() instanceof \DateTime);
    }
}
