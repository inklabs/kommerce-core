<?php
namespace inklabs\kommerce\Lib;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Lib\ReferenceNumber;

class FactoryRepository
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EntityManager $entityManager
     * @return FactoryRepository
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
     * @return EntityRepository\AttributeInterface
     */
    public function getAttribute()
    {
        return $this->entityManager->getRepository('kommerce:Attribute');
    }

    /**
     * @return EntityRepository\AttributeValueInterface
     */
    public function getAttributeValue()
    {
        return $this->entityManager->getRepository('kommerce:AttributeValue');
    }

    /**
     * @return EntityRepository\CartInterface
     */
    public function getCart()
    {
        return $this->entityManager->getRepository('kommerce:Cart');
    }

    /**
     * @return EntityRepository\CartPriceRuleInterface
     */
    public function getCartPriceRule()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRule');
    }

    /**
     * @return EntityRepository\CartPriceRuleDiscountInterface
     */
    public function getCartPriceRuleDiscount()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRuleDiscount');
    }

    /**
     * @return EntityRepository\CatalogPromotionInterface
     */
    public function getCatalogPromotion()
    {
        return $this->entityManager->getRepository('kommerce:CatalogPromotion');
    }

    /**
     * @return EntityRepository\CouponInterface
     */
    public function getCoupon()
    {
        return $this->entityManager->getRepository('kommerce:Coupon');
    }

    /**
     * @return EntityRepository\ImageInterface
     */
    public function getImage()
    {
        return $this->entityManager->getRepository('kommerce:Image');
    }

    /**
     * @return EntityRepository\OptionInterface
     */
    public function getOption()
    {
        return $this->entityManager->getRepository('kommerce:Option');
    }

    /**
     * @return EntityRepository\OptionProductInterface
     */
    public function getOptionProduct()
    {
        return $this->entityManager->getRepository('kommerce:OptionProduct');
    }

    /**
     * @return EntityRepository\OptionValueInterface
     */
    public function getOptionValue()
    {
        return $this->entityManager->getRepository('kommerce:OptionValue');
    }

    /**
     * @return EntityRepository\OrderInterface
     */
    public function getOrder()
    {
        return $this->entityManager->getRepository('kommerce:Order');
    }

    /**
     * @return EntityRepository\OrderInterface
     */
    public function getOrderWithHashSegmentGenerator()
    {
        /** @var EntityRepository\OrderInterface $orderRepository */
        $orderRepository = $this->entityManager->getRepository('kommerce:Order');
        $orderRepository->setReferenceNumberGenerator(new ReferenceNumber\HashSegmentGenerator($orderRepository));
        return $orderRepository;
    }

    /**
     * @return EntityRepository\OrderInterface
     */
    public function getOrderWithHashSequentialGenerator()
    {
        /** @var EntityRepository\OrderInterface $orderRepository */
        $orderRepository = $this->entityManager->getRepository('kommerce:Order');
        $orderRepository->setReferenceNumberGenerator(new ReferenceNumber\SequentialGenerator);
        return $orderRepository;
    }

    /**
     * @return EntityRepository\OrderItemInterface
     */
    public function getOrderItem()
    {
        return $this->entityManager->getRepository('kommerce:OrderItem');
    }

    /**
     * @return EntityRepository\OrderItemOptionProductInterface
     */
    public function getOrderItemOptionProduct()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionProduct');
    }

    /**
     * @return EntityRepository\OrderItemOptionValueInterface
     */
    public function getOrderItemOptionValue()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionValue');
    }

    /**
     * @return EntityRepository\OrderItemTextOptionValueInterface
     */
    public function getOrderItemTextOptionValue()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemTextOptionValue');
    }

    /**
     * @return EntityRepository\ProductInterface
     */
    public function getProduct()
    {
        return $this->entityManager->getRepository('kommerce:Product');
    }

    /**
     * @return EntityRepository\ProductAttributeInterface
     */
    public function getProductAttribute()
    {
        return $this->entityManager->getRepository('kommerce:ProductAttribute');
    }

    /**
     * @return EntityRepository\ProductQuantityDiscountInterface
     */
    public function getProductQuantityDiscount()
    {
        return $this->entityManager->getRepository('kommerce:ProductQuantityDiscount');
    }

    /**
     * @return EntityRepository\TagInterface
     */
    public function getTag()
    {
        return $this->entityManager->getRepository('kommerce:Tag');
    }

    /**
     * @return EntityRepository\TaxRateInterface
     */
    public function getTaxRate()
    {
        return $this->entityManager->getRepository('kommerce:TaxRate');
    }

    /**
     * @return EntityRepository\TextOptionInterface
     */
    public function getTextOption()
    {
        return $this->entityManager->getRepository('kommerce:TextOption');
    }

    /**
     * @return EntityRepository\UserInterface
     */
    public function getUser()
    {
        return $this->entityManager->getRepository('kommerce:User');
    }

    /**
     * @return EntityRepository\UserLoginInterface
     */
    public function getUserLogin()
    {
        return $this->entityManager->getRepository('kommerce:UserLogin');
    }

    /**
     * @return EntityRepository\UserRoleInterface
     */
    public function getUserRole()
    {
        return $this->entityManager->getRepository('kommerce:UserRole');
    }

    /**
     * @return EntityRepository\UserTokenInterface
     */
    public function getUserToken()
    {
        return $this->entityManager->getRepository('kommerce:UserToken');
    }

    /**
     * @return EntityRepository\WarehouseInterface
     */
    public function getWarehouse()
    {
        return $this->entityManager->getRepository('kommerce:Warehouse');
    }
}
