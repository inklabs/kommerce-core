<?php
namespace inklabs\kommerce\Lib;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemOptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemOptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemTextOptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\Payment\PaymentRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductQuantityDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRoleRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\ReferenceNumber;

class FactoryRepository
{
    /** @var EntityManager */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EntityManager $entityManager
     * @return self
     */
    public static function getInstance(EntityManager $entityManager)
    {
        static $factoryRepository = null;

        if ($factoryRepository === null) {
            $factoryRepository = new static($entityManager);
        }

        return $factoryRepository;
    }

    /**
     * @return AttributeRepositoryInterface
     */
    public function getAttributeRepository()
    {
        return $this->entityManager->getRepository('kommerce:Attribute');
    }

    /**
     * @return AttributeValueRepositoryInterface
     */
    public function getAttributeValueRepository()
    {
        return $this->entityManager->getRepository('kommerce:AttributeValue');
    }

    /**
     * @return CartRepositoryInterface
     */
    public function getCartRepository()
    {
        return $this->entityManager->getRepository('kommerce:Cart');
    }

    /**
     * @return CartPriceRuleRepositoryInterface
     */
    public function getCartPriceRuleRepository()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRule');
    }

    /**
     * @return CartPriceRuleDiscountRepositoryInterface
     */
    public function getCartPriceRuleDiscountRepository()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRuleDiscount');
    }

    /**
     * @return CatalogPromotionRepositoryInterface
     */
    public function getCatalogPromotionRepository()
    {
        return $this->entityManager->getRepository('kommerce:CatalogPromotion');
    }

    /**
     * @return CouponRepositoryInterface
     */
    public function getCouponRepository()
    {
        return $this->entityManager->getRepository('kommerce:Coupon');
    }

    /**
     * @return ImageRepositoryInterface
     */
    public function getImageRepository()
    {
        return $this->entityManager->getRepository('kommerce:Image');
    }

    /**
     * @return OptionRepositoryInterface
     */
    public function getOptionRepository()
    {
        return $this->entityManager->getRepository('kommerce:Option');
    }

    /**
     * @return OptionProductRepositoryInterface
     */
    public function getOptionProductRepository()
    {
        return $this->entityManager->getRepository('kommerce:OptionProduct');
    }

    /**
     * @return OptionValueRepositoryInterface
     */
    public function getOptionValueRepository()
    {
        return $this->entityManager->getRepository('kommerce:OptionValue');
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderRepository()
    {
        return $this->entityManager->getRepository('kommerce:Order');
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderWithHashSegmentGenerator()
    {
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = $this->entityManager->getRepository('kommerce:Order');
        $orderRepository->setReferenceNumberGenerator(new ReferenceNumber\HashSegmentGenerator($orderRepository));
        return $orderRepository;
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderWithSequentialGenerator()
    {
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = $this->entityManager->getRepository('kommerce:Order');
        $orderRepository->setReferenceNumberGenerator(new ReferenceNumber\SequentialGenerator);
        return $orderRepository;
    }

    /**
     * @return OrderItemRepositoryInterface
     */
    public function getOrderItemRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItem');
    }

    /**
     * @return OrderItemOptionProductRepositoryInterface
     */
    public function getOrderItemOptionProductRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionProduct');
    }

    /**
     * @return OrderItemOptionValueRepositoryInterface
     */
    public function getOrderItemOptionValueRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionValue');
    }

    /**
     * @return OrderItemTextOptionValueRepositoryInterface
     */
    public function getOrderItemTextOptionValueRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemTextOptionValue');
    }

    /**
     * @return PaymentRepositoryInterface
     */
    public function getPaymentRepository()
    {
        return $this->entityManager->getRepository('kommerce:Payment\AbstractPayment');
    }

    /**
     * @return ProductRepositoryInterface
     */
    public function getProductRepository()
    {
        return $this->entityManager->getRepository('kommerce:Product');
    }

    /**
     * @return ProductAttributeRepositoryInterface
     */
    public function getProductAttributeRepository()
    {
        return $this->entityManager->getRepository('kommerce:ProductAttribute');
    }

    /**
     * @return ProductQuantityDiscountRepositoryInterface
     */
    public function getProductQuantityDiscountRepository()
    {
        return $this->entityManager->getRepository('kommerce:ProductQuantityDiscount');
    }

    /**
     * @return TagRepositoryInterface
     */
    public function getTagRepository()
    {
        return $this->entityManager->getRepository('kommerce:Tag');
    }

    /**
     * @return TaxRateRepositoryInterface
     */
    public function getTaxRateRepository()
    {
        return $this->entityManager->getRepository('kommerce:TaxRate');
    }

    /**
     * @return TextOptionRepositoryInterface
     */
    public function getTextOptionRepository()
    {
        return $this->entityManager->getRepository('kommerce:TextOption');
    }

    /**
     * @return UserRepositoryInterface
     */
    public function getUserRepository()
    {
        return $this->entityManager->getRepository('kommerce:User');
    }

    /**
     * @return UserLoginRepositoryInterface
     */
    public function getUserLoginRepository()
    {
        return $this->entityManager->getRepository('kommerce:UserLogin');
    }

    /**
     * @return UserRoleRepositoryInterface
     */
    public function getUserRoleRepository()
    {
        return $this->entityManager->getRepository('kommerce:UserRole');
    }

    /**
     * @return UserTokenRepositoryInterface
     */
    public function getUserTokenRepository()
    {
        return $this->entityManager->getRepository('kommerce:UserToken');
    }

    /**
     * @return WarehouseRepositoryInterface
     */
    public function getWarehouseRepository()
    {
        return $this->entityManager->getRepository('kommerce:Warehouse');
    }
}
