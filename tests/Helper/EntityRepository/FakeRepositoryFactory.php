<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemOptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemOptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemTextOptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\PaymentRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductQuantityDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRoleRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber;

class FakeRepositoryFactory implements RepositoryFactoryInterface
{
    /**
     * @param EntityManager $entityManager
     * @return self
     */
    public static function getInstance(EntityManager $entityManager)
    {
        static $repositoryFactory = null;

        if ($repositoryFactory === null) {
            $repositoryFactory = new static($entityManager);
        }

        return $repositoryFactory;
    }

    /**
     * @return AttributeRepositoryInterface
     */
    public function getAttributeRepository()
    {
        return new FakeAttributeRepository;
    }

    /**
     * @return AttributeValueRepositoryInterface
     */
    public function getAttributeValueRepository()
    {
        return new FakeAttributeValueRepository;
    }

    /**
     * @return CartRepositoryInterface
     */
    public function getCartRepository()
    {
        return new FakeCartRepository;
    }

    /**
     * @return CartPriceRuleRepositoryInterface
     */
    public function getCartPriceRuleRepository()
    {
        return new FakeCartPriceRuleRepository;
    }

    /**
     * @return CartPriceRuleDiscountRepositoryInterface
     */
    public function getCartPriceRuleDiscountRepository()
    {
        //return new FakeCartPriceRuleDiscountRepository;
    }

    /**
     * @return CatalogPromotionRepositoryInterface
     */
    public function getCatalogPromotionRepository()
    {
        return new FakeCatalogPromotionRepository;
    }

    /**
     * @return CouponRepositoryInterface
     */
    public function getCouponRepository()
    {
        return new FakeCouponRepository;
    }

    /**
     * @return ImageRepositoryInterface
     */
    public function getImageRepository()
    {
        return new FakeImageRepository;
    }

    /**
     * @return OptionRepositoryInterface
     */
    public function getOptionRepository()
    {
        return new FakeOptionRepository;
    }

    /**
     * @return OptionProductRepositoryInterface
     */
    public function getOptionProductRepository()
    {
        return new FakeOptionProductRepository;
    }

    /**
     * @return OptionValueRepositoryInterface
     */
    public function getOptionValueRepository()
    {
        return new FakeOptionValueRepository;
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderRepository()
    {
        return new FakeOrderRepository;
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderWithHashSegmentGenerator()
    {
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new FakeOrderRepository;
        $orderRepository->setReferenceNumberGenerator(new ReferenceNumber\HashSegmentGenerator($orderRepository));
        return $orderRepository;
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderWithSequentialGenerator()
    {
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new FakeOrderRepository;
        $orderRepository->setReferenceNumberGenerator(new ReferenceNumber\SequentialGenerator);
        return $orderRepository;
    }

    /**
     * @return OrderItemRepositoryInterface
     */
    public function getOrderItemRepository()
    {
        return new FakeOrderItemRepository;
    }

    /**
     * @return OrderItemOptionProductRepositoryInterface
     */
    public function getOrderItemOptionProductRepository()
    {
        //return new FakeOrderItemOptionProductRepository;
    }

    /**
     * @return OrderItemOptionValueRepositoryInterface
     */
    public function getOrderItemOptionValueRepository()
    {
        //return new FakeOrderItemOptionValueRepository;
    }

    /**
     * @return OrderItemTextOptionValueRepositoryInterface
     */
    public function getOrderItemTextOptionValueRepository()
    {
        //return new FakeOrderItemTextOptionValueRepository;
    }

    /**
     * @return PaymentRepositoryInterface
     */
    public function getPaymentRepository()
    {
        //return new FakeAbstractPaymentRepository;
    }

    /**
     * @return ProductRepositoryInterface
     */
    public function getProductRepository()
    {
        //return new FakeProductRepository;
    }

    /**
     * @return ProductAttributeRepositoryInterface
     */
    public function getProductAttributeRepository()
    {
        //return new FakeProductAttributeRepository;
    }

    /**
     * @return ProductQuantityDiscountRepositoryInterface
     */
    public function getProductQuantityDiscountRepository()
    {
        //return new FakeProductQuantityDiscountRepository;
    }

    /**
     * @return TagRepositoryInterface
     */
    public function getTagRepository()
    {
        return new FakeTagRepository;
    }

    /**
     * @return TaxRateRepositoryInterface
     */
    public function getTaxRateRepository()
    {
        return new FakeTaxRateRepository;
    }

    /**
     * @return TextOptionRepositoryInterface
     */
    public function getTextOptionRepository()
    {
        return new FakeTextOptionRepository;
    }

    /**
     * @return UserRepositoryInterface
     */
    public function getUserRepository()
    {
        return new FakeUserRepository;
    }

    /**
     * @return UserLoginRepositoryInterface
     */
    public function getUserLoginRepository()
    {
        return new FakeUserLoginRepository;
    }

    /**
     * @return UserRoleRepositoryInterface
     */
    public function getUserRoleRepository()
    {
        //return new FakeUserRoleRepository;
    }

    /**
     * @return UserTokenRepositoryInterface
     */
    public function getUserTokenRepository()
    {
        //return new FakeUserTokenRepository;
    }

    /**
     * @return WarehouseRepositoryInterface
     */
    public function getWarehouseRepository()
    {
        //return new FakeWarehouseRepository;
    }
}
