<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OptionRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionProduct::class,
        OptionValue::class,
        Product::class,
        Tag::class,
    ];

    /** @var OptionRepositoryInterface */
    protected $optionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->optionRepository = $this->getRepositoryFactory()->getOptionRepository();
    }

    private function setupOption()
    {
        $option = $this->dummyData->getOption();

        $this->entityManager->persist($option);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $option;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->optionRepository,
            $this->dummyData->getOption()
        );
    }

    public function testFind()
    {
        $originalOption = $this->setupOption();
        $this->setCountLogger();

        $option = $this->optionRepository->findOneById(
            $originalOption->getId()
        );

        $this->visitElements($option->getOptionProducts());
        $this->visitElements($option->getOptionValues());
        $this->visitElements($option->getTags());

        $this->assertEquals($originalOption->getId(), $option->getid());
        $this->assertSame(4, $this->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $originalOption = $this->setupOption();

        $options = $this->optionRepository->getAllOptionsByIds([
            $originalOption->getId()
        ]);

        $this->assertEquals($originalOption->getId(), $options[0]->getId());
    }

    public function testGetAllOptions()
    {
        $originalOption = $this->setupOption();

        $options = $this->optionRepository->getAllOptions('ze');

        $this->assertEquals($originalOption->getId(), $options[0]->getId());
    }

    public function testGetOptionValueById()
    {
        $option = $this->dummyData->getOption();
        $optionValue1 = $this->dummyData->getOptionValue($option);
        $this->entityManager->persist($option);
        $this->entityManager->persist($optionValue1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $optionValue = $this->optionRepository->getOptionValueById($optionValue1->getId());

        $this->assertEqualEntities($optionValue1, $optionValue);
    }

    public function testGetOptionProductById()
    {
        $option = $this->dummyData->getOption();
        $product = $this->dummyData->getProduct();
        $optionProduct1 = $this->dummyData->getOptionProduct($option, $product);
        $this->entityManager->persist($option);
        $this->entityManager->persist($product);
        $this->entityManager->persist($optionProduct1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $optionProduct = $this->optionRepository->getOptionProductById($optionProduct1->getId());

        $this->assertEqualEntities($optionProduct1, $optionProduct);
    }
}
