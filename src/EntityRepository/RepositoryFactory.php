<?php
namespace inklabs\kommerce\EntityRepository;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Configuration;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Lib\ReferenceNumber\HashSegmentReferenceNumberGenerator;

class RepositoryFactory
{
    /** @var EntityManager */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return AttachmentRepositoryInterface
     */
    public function getAttachmentRepository()
    {
        return $this->entityManager->getRepository(Attachment::class);
    }

    /**
     * @return AttributeRepositoryInterface
     */
    public function getAttributeRepository()
    {
        return $this->entityManager->getRepository(Attribute::class);
    }

    /**
     * @return AttributeValueRepositoryInterface
     */
    public function getAttributeValueRepository()
    {
        return $this->entityManager->getRepository(AttributeValue::class);
    }

    /**
     * @return CartRepositoryInterface
     */
    public function getCartRepository()
    {
        return $this->entityManager->getRepository(Cart::class);
    }

    /**
     * @return CartPriceRuleRepositoryInterface
     */
    public function getCartPriceRuleRepository()
    {
        return $this->entityManager->getRepository(CartPriceRule::class);
    }

    /**
     * @return CartPriceRuleDiscountRepositoryInterface
     */
    public function getCartPriceRuleDiscountRepository()
    {
        return $this->entityManager->getRepository(CartPriceRuleDiscount::class);
    }

    /**
     * @return CartPriceRuleItemRepositoryInterface
     */
    public function getCartPriceRuleItemRepository()
    {
        return $this->entityManager->getRepository(AbstractCartPriceRuleItem::class);
    }

    /**
     * @return CatalogPromotionRepositoryInterface
     */
    public function getCatalogPromotionRepository()
    {
        return $this->entityManager->getRepository(CatalogPromotion::class);
    }

    /**
     * @return ConfigurationRepositoryInterface
     */
    public function getConfigurationRepository()
    {
        return $this->entityManager->getRepository(Configuration::class);
    }

    /**
     * @return CouponRepositoryInterface
     */
    public function getCouponRepository()
    {
        return $this->entityManager->getRepository(Coupon::class);
    }

    /**
     * @return ImageRepositoryInterface
     */
    public function getImageRepository()
    {
        return $this->entityManager->getRepository(Image::class);
    }

    /**
     * @return InventoryLocationRepositoryInterface
     */
    public function getInventoryLocationRepository()
    {
        return $this->entityManager->getRepository(InventoryLocation::class);
    }

    /**
     * @return InventoryTransactionRepositoryInterface
     */
    public function getInventoryTransactionRepository()
    {
        return $this->entityManager->getRepository(InventoryTransaction::class);
    }

    /**
     * @return OptionRepositoryInterface
     */
    public function getOptionRepository()
    {
        return $this->entityManager->getRepository(Option::class);
    }

    /**
     * @return OptionProductRepositoryInterface
     */
    public function getOptionProductRepository()
    {
        return $this->entityManager->getRepository(OptionProduct::class);
    }

    /**
     * @return OptionValueRepositoryInterface
     */
    public function getOptionValueRepository()
    {
        return $this->entityManager->getRepository(OptionValue::class);
    }

    /**
     * @return OrderRepositoryInterface
     */
    public function getOrderRepository()
    {
        return $this->entityManager->getRepository(Order::class);
    }

    /**
     * @return OrderItemRepositoryInterface
     */
    public function getOrderItemRepository()
    {
        return $this->entityManager->getRepository(OrderItem::class);
    }

    /**
     * @return OrderItemOptionProductRepositoryInterface
     */
    public function getOrderItemOptionProductRepository()
    {
        return $this->entityManager->getRepository(OrderItemOptionProduct::class);
    }

    /**
     * @return OrderItemOptionValueRepositoryInterface
     */
    public function getOrderItemOptionValueRepository()
    {
        return $this->entityManager->getRepository(OrderItemOptionValue::class);
    }

    /**
     * @return OrderItemTextOptionValueRepositoryInterface
     */
    public function getOrderItemTextOptionValueRepository()
    {
        return $this->entityManager->getRepository(OrderItemTextOptionValue::class);
    }

    /**
     * @return PaymentRepositoryInterface
     */
    public function getPaymentRepository()
    {
        return $this->entityManager->getRepository(AbstractPayment::class);
    }

    /**
     * @return ProductRepositoryInterface
     */
    public function getProductRepository()
    {
        return $this->entityManager->getRepository(Product::class);
    }

    /**
     * @return ProductAttributeRepositoryInterface
     */
    public function getProductAttributeRepository()
    {
        return $this->entityManager->getRepository(ProductAttribute::class);
    }

    /**
     * @return ProductQuantityDiscountRepositoryInterface
     */
    public function getProductQuantityDiscountRepository()
    {
        return $this->entityManager->getRepository(ProductQuantityDiscount::class);
    }

    /**
     * @return ShipmentTrackerRepositoryInterface
     */
    public function getShipmentTrackerRepository()
    {
        return $this->entityManager->getRepository(ShipmentTracker::class);
    }

    /**
     * @return TagRepositoryInterface
     */
    public function getTagRepository()
    {
        return $this->entityManager->getRepository(Tag::class);
    }

    /**
     * @return TaxRateRepositoryInterface
     */
    public function getTaxRateRepository()
    {
        return $this->entityManager->getRepository(TaxRate::class);
    }

    /**
     * @return TextOptionRepositoryInterface
     */
    public function getTextOptionRepository()
    {
        return $this->entityManager->getRepository(TextOption::class);
    }

    /**
     * @return UserRepositoryInterface
     */
    public function getUserRepository()
    {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @return UserLoginRepositoryInterface
     */
    public function getUserLoginRepository()
    {
        return $this->entityManager->getRepository(UserLogin::class);
    }

    /**
     * @return UserRoleRepositoryInterface
     */
    public function getUserRoleRepository()
    {
        return $this->entityManager->getRepository(UserRole::class);
    }

    /**
     * @return UserTokenRepositoryInterface
     */
    public function getUserTokenRepository()
    {
        return $this->entityManager->getRepository(UserToken::class);
    }

    /**
     * @return WarehouseRepositoryInterface
     */
    public function getWarehouseRepository()
    {
        return $this->entityManager->getRepository(Warehouse::class);
    }
}
