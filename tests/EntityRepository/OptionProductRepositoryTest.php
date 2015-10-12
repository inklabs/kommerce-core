<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\tests\Helper;

class OptionProductRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionProduct',
        'kommerce:Product',
    ];

    /** @var OptionProductRepositoryInterface */
    protected $optionProductRepository;

    public function setUp()
    {
        $this->optionProductRepository = $this->getRepositoryFactory()->getOptionProductRepository();
    }

    private function setupOptionProduct()
    {
        $product = $this->getDummyProduct();
        $option = $this->getDummyOption();
        $optionProduct = $this->getDummyOptionProduct($option, $product);

        $this->entityManager->persist($option);
        $this->entityManager->persist($product);

        $this->optionProductRepository->create($optionProduct);

        return $optionProduct;
    }

    public function testCRUD()
    {
        $optionProduct = $this->setupOptionProduct();
        $this->assertSame(1, $optionProduct->getId());

        $optionProduct->setSortOrder(5);
        $this->assertSame(null, $optionProduct->getUpdated());

        $this->optionProductRepository->update($optionProduct);
        $this->assertTrue($optionProduct->getUpdated() instanceof \DateTime);

        $this->optionProductRepository->delete($optionProduct);
        $this->assertSame(null, $optionProduct->getId());
    }

    public function testFind()
    {
        $this->setupOptionProduct();

        $this->setCountLogger();

        $optionProduct = $this->optionProductRepository->findOneById(1);

        $optionProduct->getProduct()->getCreated();
        $optionProduct->getOption()->getCreated();

        $this->assertTrue($optionProduct instanceof OptionProduct);
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $this->setupOptionProduct();

        $this->setCountLogger();

        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds([1]);

        $optionProducts[0]->getProduct()->getCreated();
        $optionProducts[0]->getOption()->getCreated();

        $this->assertTrue($optionProducts[0] instanceof OptionProduct);
        $this->assertSame(1, $this->getTotalQueries());
    }
}
