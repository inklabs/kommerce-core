<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OptionProductRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionProduct::class,
        Product::class,
    ];

    /** @var OptionProductRepositoryInterface */
    protected $optionProductRepository;

    public function setUp()
    {
        parent::setUp();
        $this->optionProductRepository = $this->getRepositoryFactory()->getOptionProductRepository();
    }

    private function setupOptionProduct()
    {
        $product = $this->dummyData->getProduct();
        $option = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product);

        $this->entityManager->persist($option);
        $this->entityManager->persist($product);

        $this->optionProductRepository->create($optionProduct);

        return $optionProduct;
    }

    public function testCRUD()
    {
        $option = $this->dummyData->getOption();
        $product = $this->dummyData->getProduct();
        $this->entityManager->persist($option);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->executeRepositoryCRUD(
            $this->optionProductRepository,
            $this->dummyData->getOptionProduct($option, $product)
        );
    }

    public function testFind()
    {
        $originalOptionProduct = $this->setupOptionProduct();
        $this->setCountLogger();

        $optionProduct = $this->optionProductRepository->findOneById(
            $originalOptionProduct->getId()
        );

        $optionProduct->getProduct()->getCreated();
        $optionProduct->getOption()->getCreated();

        $this->assertEquals($originalOptionProduct->getid(), $optionProduct->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testGetAllOptionValuesByIds()
    {
        $originalOptionProduct = $this->setupOptionProduct();
        $this->setCountLogger();

        $optionProducts = $this->optionProductRepository->getAllOptionProductsByIds([
            $originalOptionProduct->getId()
        ]);

        $optionProducts[0]->getProduct()->getCreated();
        $optionProducts[0]->getOption()->getCreated();

        $this->assertEquals($originalOptionProduct->getid(), $optionProducts[0]->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }
}
