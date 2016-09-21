<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use Mockery;
use inklabs\kommerce\tests\Helper\Entity\DummyData;

class MockRepository
{
    /** @var DummyData */
    protected $dummyData;

    public function __construct(DummyData $dummyData)
    {
        $this->dummyData = $dummyData;
    }

    /**
     * @param string $className
     * @return Mockery\Mock
     */
    protected function getMockeryMock($className)
    {
        return Mockery::mock($className);
    }

    /**
     * @return AttachmentRepositoryInterface|Mockery\Mock
     */
    public function getAttachmentRepository()
    {
        return $this->getMockeryMock(AttachmentRepositoryInterface::class);
    }

    /**
     * @return AttributeRepositoryInterface|Mockery\Mock
     */
    public function getAttributeRepository()
    {
        return $this->getMockeryMock(AttributeRepositoryInterface::class);
    }

    /**
     * @return AttributeValueRepositoryInterface|Mockery\Mock
     */
    public function getAttributeValueRepository()
    {
        return $this->getMockeryMock(AttributeValueRepositoryInterface::class);
    }

    /**
     * @return CartRepositoryInterface|Mockery\Mock
     */
    public function getCartRepository()
    {
        return $this->getMockeryMock(CartRepositoryInterface::class);
    }

    /**
     * @return CartPriceRuleRepositoryInterface|Mockery\Mock
     */
    public function getCartPriceRuleRepository()
    {
        return $this->getMockeryMock(CartPriceRuleRepositoryInterface::class);
    }

    /**
     * @return CatalogPromotionRepositoryInterface|Mockery\Mock
     */
    public function getCatalogPromotionRepository()
    {
        return $this->getMockeryMock(CatalogPromotionRepositoryInterface::class);
    }

    /**
     * @return CouponRepositoryInterface|Mockery\Mock
     */
    public function getCouponRepository()
    {
        return $this->getMockeryMock(CouponRepositoryInterface::class);
    }

    /**
     * @return ImageRepositoryInterface|Mockery\Mock
     */
    public function getImageRepository()
    {
        return $this->getMockeryMock(ImageRepositoryInterface::class);
    }

    /**
     * @return InventoryLocationRepositoryInterface|Mockery\Mock
     */
    public function getInventoryLocationRepository()
    {
        return $this->getMockeryMock(InventoryLocationRepositoryInterface::class);
    }

    /**
     * @return InventoryTransactionRepositoryInterface|Mockery\Mock
     */
    public function getInventoryTransactionRepository()
    {
        return $this->getMockeryMock(InventoryTransactionRepositoryInterface::class);
    }

    /**
     * @return OptionRepositoryInterface|Mockery\Mock
     */
    public function getOptionRepository()
    {
        return $this->getMockeryMock(OptionRepositoryInterface::class);
    }

    /**
     * @return OptionProductRepositoryInterface|Mockery\Mock
     */
    public function getOptionProductRepository()
    {
        return $this->getMockeryMock(OptionProductRepositoryInterface::class);
    }

    /**
     * @return OptionValueRepositoryInterface|Mockery\Mock
     */
    public function getOptionValueRepository()
    {
        return $this->getMockeryMock(OptionValueRepositoryInterface::class);
    }

    /**
     * @return OrderRepositoryInterface|Mockery\Mock
     */
    public function getOrderRepository()
    {
        return $this->getMockeryMock(OrderRepositoryInterface::class);
    }

    /**
     * @return OrderItemRepositoryInterface|Mockery\Mock
     */
    public function getOrderItemRepository()
    {
        return $this->getMockeryMock(OrderItemRepositoryInterface::class);
    }

    /**
     * @return ProductRepositoryInterface|Mockery\Mock
     */
    public function getProductRepository()
    {
        return $this->getMockeryMock(ProductRepositoryInterface::class);
    }

    /**
     * @return TagRepositoryInterface|Mockery\Mock
     */
    public function getTagRepository()
    {
        return $this->getMockeryMock(TagRepositoryInterface::class);
    }

    /**
     * @return TextOptionRepositoryInterface|Mockery\Mock
     */
    public function getTextOptionRepository()
    {
        return $this->getMockeryMock(TextOptionRepositoryInterface::class);
    }

    /**
     * @return TaxRateRepositoryInterface|Mockery\Mock
     */
    public function getTaxRateRepository()
    {
        return $this->getMockeryMock(TaxRateRepositoryInterface::class);
    }

    /**
     * @return UserRepositoryInterface|Mockery\Mock
     */
    public function getUserRepository()
    {
        return $this->getMockeryMock(UserRepositoryInterface::class);
    }

    /**
     * @return UserLoginRepositoryInterface|Mockery\Mock
     */
    public function getUserLoginRepository()
    {
        return $this->getMockeryMock(UserLoginRepositoryInterface::class);
    }

    /**
     * @return UserTokenRepositoryInterface|Mockery\Mock
     */
    public function getUserTokenRepository()
    {
        return $this->getMockeryMock(UserTokenRepositoryInterface::class);
    }
}
