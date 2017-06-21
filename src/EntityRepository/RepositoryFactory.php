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

class RepositoryFactory
{
    /** @var EntityManager */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAttachmentRepository(): AttachmentRepositoryInterface
    {
        return $this->entityManager->getRepository(Attachment::class);
    }

    public function getAttributeRepository(): AttributeRepositoryInterface
    {
        return $this->entityManager->getRepository(Attribute::class);
    }

    public function getAttributeValueRepository(): AttributeValueRepositoryInterface
    {
        return $this->entityManager->getRepository(AttributeValue::class);
    }

    public function getCartRepository(): CartRepositoryInterface
    {
        return $this->entityManager->getRepository(Cart::class);
    }

    public function getCartPriceRuleRepository(): CartPriceRuleRepositoryInterface
    {
        return $this->entityManager->getRepository(CartPriceRule::class);
    }

    public function getCartPriceRuleDiscountRepository(): CartPriceRuleDiscountRepositoryInterface
    {
        return $this->entityManager->getRepository(CartPriceRuleDiscount::class);
    }

    public function getCartPriceRuleItemRepository(): CartPriceRuleItemRepositoryInterface
    {
        return $this->entityManager->getRepository(AbstractCartPriceRuleItem::class);
    }

    public function getCatalogPromotionRepository(): CatalogPromotionRepositoryInterface
    {
        return $this->entityManager->getRepository(CatalogPromotion::class);
    }

    public function getConfigurationRepository(): ConfigurationRepositoryInterface
    {
        return $this->entityManager->getRepository(Configuration::class);
    }

    public function getCouponRepository(): CouponRepositoryInterface
    {
        return $this->entityManager->getRepository(Coupon::class);
    }

    public function getImageRepository(): ImageRepositoryInterface
    {
        return $this->entityManager->getRepository(Image::class);
    }

    public function getInventoryLocationRepository(): InventoryLocationRepositoryInterface
    {
        return $this->entityManager->getRepository(InventoryLocation::class);
    }

    public function getInventoryTransactionRepository(): InventoryTransactionRepositoryInterface
    {
        return $this->entityManager->getRepository(InventoryTransaction::class);
    }

    public function getOptionRepository(): OptionRepositoryInterface
    {
        return $this->entityManager->getRepository(Option::class);
    }

    public function getOptionProductRepository(): OptionProductRepositoryInterface
    {
        return $this->entityManager->getRepository(OptionProduct::class);
    }

    public function getOptionValueRepository(): OptionValueRepositoryInterface
    {
        return $this->entityManager->getRepository(OptionValue::class);
    }

    public function getOrderRepository(): OrderRepositoryInterface
    {
        return $this->entityManager->getRepository(Order::class);
    }

    public function getOrderItemRepository(): OrderItemRepositoryInterface
    {
        return $this->entityManager->getRepository(OrderItem::class);
    }

    public function getOrderItemOptionProductRepository(): OrderItemOptionProductRepositoryInterface
    {
        return $this->entityManager->getRepository(OrderItemOptionProduct::class);
    }

    public function getOrderItemOptionValueRepository(): OrderItemOptionValueRepositoryInterface
    {
        return $this->entityManager->getRepository(OrderItemOptionValue::class);
    }

    public function getOrderItemTextOptionValueRepository(): OrderItemTextOptionValueRepositoryInterface
    {
        return $this->entityManager->getRepository(OrderItemTextOptionValue::class);
    }

    public function getPaymentRepository(): PaymentRepositoryInterface
    {
        return $this->entityManager->getRepository(AbstractPayment::class);
    }

    public function getProductRepository(): ProductRepositoryInterface
    {
        return $this->entityManager->getRepository(Product::class);
    }

    public function getProductAttributeRepository(): ProductAttributeRepositoryInterface
    {
        return $this->entityManager->getRepository(ProductAttribute::class);
    }

    public function getProductQuantityDiscountRepository(): ProductQuantityDiscountRepositoryInterface
    {
        return $this->entityManager->getRepository(ProductQuantityDiscount::class);
    }

    public function getShipmentTrackerRepository(): ShipmentTrackerRepositoryInterface
    {
        return $this->entityManager->getRepository(ShipmentTracker::class);
    }

    public function getTagRepository(): TagRepositoryInterface
    {
        return $this->entityManager->getRepository(Tag::class);
    }

    public function getTaxRateRepository(): TaxRateRepositoryInterface
    {
        return $this->entityManager->getRepository(TaxRate::class);
    }

    public function getTextOptionRepository(): TextOptionRepositoryInterface
    {
        return $this->entityManager->getRepository(TextOption::class);
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        return $this->entityManager->getRepository(User::class);
    }

    public function getUserLoginRepository(): UserLoginRepositoryInterface
    {
        return $this->entityManager->getRepository(UserLogin::class);
    }

    public function getUserRoleRepository(): UserRoleRepositoryInterface
    {
        return $this->entityManager->getRepository(UserRole::class);
    }

    public function getUserTokenRepository(): UserTokenRepositoryInterface
    {
        return $this->entityManager->getRepository(UserToken::class);
    }

    public function getWarehouseRepository(): WarehouseRepositoryInterface
    {
        return $this->entityManager->getRepository(Warehouse::class);
    }
}
