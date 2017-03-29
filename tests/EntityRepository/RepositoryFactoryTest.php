<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class RepositoryFactoryTest extends EntityRepositoryTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->setupEntityManager();
    }

    public function testGetRepositories()
    {
        $repositoryFactory = new RepositoryFactory($this->entityManager);
        $this->assertTrue($repositoryFactory->getAttributeRepository() instanceof AttributeRepository);
        $this->assertTrue($repositoryFactory->getAttributeValueRepository() instanceof AttributeValueRepository);
        $this->assertTrue($repositoryFactory->getCartRepository() instanceof CartRepository);
        $this->assertTrue($repositoryFactory->getCartPriceRuleRepository() instanceof CartPriceRuleRepository);
        $this->assertTrue(
            $repositoryFactory->getCartPriceRuleDiscountRepository()
            instanceof CartPriceRuleDiscountRepository
        );
        $this->assertTrue($repositoryFactory->getCartPriceRuleItemRepository() instanceof CartPriceRuleItemRepository);
        $this->assertTrue($repositoryFactory->getCatalogPromotionRepository() instanceof CatalogPromotionRepository);
        $this->assertTrue($repositoryFactory->getCouponRepository() instanceof CouponRepository);
        $this->assertTrue($repositoryFactory->getImageRepository() instanceof ImageRepository);
        $this->assertTrue($repositoryFactory->getInventoryLocationRepository() instanceof InventoryLocationRepository);
        $this->assertTrue(
            $repositoryFactory->getInventoryTransactionRepository()
            instanceof InventoryTransactionRepository
        );
        $this->assertTrue($repositoryFactory->getOptionRepository() instanceof OptionRepository);
        $this->assertTrue($repositoryFactory->getOptionProductRepository() instanceof OptionProductRepository);
        $this->assertTrue($repositoryFactory->getOptionValueRepository() instanceof OptionValueRepository);
        $this->assertTrue($repositoryFactory->getOrderRepository() instanceof OrderRepository);
        $this->assertTrue($repositoryFactory->getOrderItemRepository() instanceof OrderItemRepository);
        $this->assertTrue(
            $repositoryFactory->getOrderItemOptionProductRepository()
            instanceof OrderItemOptionProductRepository
        );
        $this->assertTrue(
            $repositoryFactory->getOrderItemOptionValueRepository()
            instanceof OrderItemOptionValueRepository
        );
        $this->assertTrue(
            $repositoryFactory->getOrderItemTextOptionValueRepository()
            instanceof OrderItemTextOptionValueRepository
        );
        $this->assertTrue($repositoryFactory->getPaymentRepository() instanceof PaymentRepository);
        $this->assertTrue($repositoryFactory->getProductRepository() instanceof ProductRepository);
        $this->assertTrue($repositoryFactory->getProductAttributeRepository() instanceof ProductAttributeRepository);
        $this->assertTrue(
            $repositoryFactory->getProductQuantityDiscountRepository()
            instanceof ProductQuantityDiscountRepository
        );
        $this->assertTrue($repositoryFactory->getTagRepository() instanceof TagRepository);
        $this->assertTrue($repositoryFactory->getTaxRateRepository() instanceof TaxRateRepository);
        $this->assertTrue($repositoryFactory->getTextOptionRepository() instanceof TextOptionRepository);
        $this->assertTrue($repositoryFactory->getUserRepository() instanceof UserRepository);
        $this->assertTrue($repositoryFactory->getUserLoginRepository() instanceof UserLoginRepository);
        $this->assertTrue($repositoryFactory->getUserRoleRepository() instanceof UserRoleRepository);
        $this->assertTrue($repositoryFactory->getUserTokenRepository() instanceof UserTokenRepository);
        $this->assertTrue($repositoryFactory->getWarehouseRepository() instanceof WarehouseRepository);
    }
}
