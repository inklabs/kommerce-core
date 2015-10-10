<?php
namespace inklabs\kommerce\EntityRepository;

use Doctrine\ORM\EntityManager;

interface RepositoryFactoryInterface
{
    /**
     * @param EntityManager $entityManager
     * @return self
     */
    public static function getInstance(EntityManager $entityManager);

    /**
     * @return AttributeRepositoryInterface
     */
    public function getAttributeRepository();

    /**
     * @return AttributeValueRepositoryInterface
     */
    public function getAttributeValueRepository();

    /**
     * @return CartRepositoryInterface
     */
    public function getCartRepository();

    /**
     * @return CartPriceRuleRepositoryInterface
     */
    public function getCartPriceRuleRepository();

    /**
     * @return CartPriceRuleDiscountRepositoryInterface
     */
    public function getCartPriceRuleDiscountRepository();

    /**
     * @return CatalogPromotionRepositoryInterface
     */
    public function getCatalogPromotionRepository();

    /**
     * @return CouponRepositoryInterface
     */
    public function getCouponRepository();

    /**
     * @return ImageRepositoryInterface
     */
    public function getImageRepository();

    /**
     * @return OptionRepositoryInterface
     */
    public function getOptionRepository();

    /**
     * @return OptionProductRepositoryInterface
     */
    public function getOptionProductRepository();

    /**
     * @return OptionValueRepositoryInterface
     */
    public function getOptionValueRepository();

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderRepository();

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderWithHashSegmentGenerator();

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderWithSequentialGenerator();

    /**
     * @return OrderItemRepositoryInterface
     */
    public function getOrderItemRepository();

    /**
     * @return OrderItemOptionProductRepositoryInterface
     */
    public function getOrderItemOptionProductRepository();

    /**
     * @return OrderItemOptionValueRepositoryInterface
     */
    public function getOrderItemOptionValueRepository();

    /**
     * @return OrderItemTextOptionValueRepositoryInterface
     */
    public function getOrderItemTextOptionValueRepository();

    /**
     * @return PaymentRepositoryInterface
     */
    public function getPaymentRepository();

    /**
     * @return ProductRepositoryInterface
     */
    public function getProductRepository();

    /**
     * @return ProductAttributeRepositoryInterface
     */
    public function getProductAttributeRepository();

    /**
     * @return ProductQuantityDiscountRepositoryInterface
     */
    public function getProductQuantityDiscountRepository();

    /**
     * @return TagRepositoryInterface
     */
    public function getTagRepository();

    /**
     * @return TaxRateRepositoryInterface
     */
    public function getTaxRateRepository();

    /**
     * @return TextOptionRepositoryInterface
     */
    public function getTextOptionRepository();

    /**
     * @return UserRepositoryInterface
     */
    public function getUserRepository();

    /**
     * @return UserLoginRepositoryInterface
     */
    public function getUserLoginRepository();

    /**
     * @return UserRoleRepositoryInterface
     */
    public function getUserRoleRepository();

    /**
     * @return UserTokenRepositoryInterface
     */
    public function getUserTokenRepository();

    /**
     * @return WarehouseRepositoryInterface
     */
    public function getWarehouseRepository();
}
