<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\Import\ImportOrderItemService;
use inklabs\kommerce\Service\Import\ImportOrderService;
use inklabs\kommerce\Service\Import\ImportPaymentService;
use inklabs\kommerce\Service\Import\ImportUserService;
use inklabs\kommerce\tests\Helper;

class ServiceFactoryTest extends Helper\TestCase\ServiceTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setupEntityManager();
    }

    public function testGetServices()
    {
        $serviceFactory = $this->getServiceFactory(new CartCalculator(new Pricing));
        $this->assertTrue($serviceFactory->getAttribute() instanceof AttributeService);
        $this->assertTrue($serviceFactory->getAttributeValue() instanceof AttributeValueService);
        $this->assertTrue($serviceFactory->getCart() instanceof CartService);
        $this->assertTrue($serviceFactory->getCartPriceRule() instanceof CartPriceRuleService);
        $this->assertTrue($serviceFactory->getCatalogPromotion() instanceof CatalogPromotionService);
        $this->assertTrue($serviceFactory->getCoupon() instanceof CouponService);
        $this->assertTrue($serviceFactory->getImageService() instanceof ImageService);
        $this->assertTrue($serviceFactory->getImportOrder() instanceof ImportOrderService);
        $this->assertTrue($serviceFactory->getImportOrderItem() instanceof ImportOrderItemService);
        $this->assertTrue($serviceFactory->getImportPayment() instanceof ImportPaymentService);
        $this->assertTrue($serviceFactory->getImportUser() instanceof ImportUserService);
        $this->assertTrue($serviceFactory->getOption() instanceof OptionService);
        $this->assertTrue($serviceFactory->getOrder() instanceof OrderService);
        $this->assertTrue($serviceFactory->getProduct() instanceof ProductService);
        $this->assertTrue($serviceFactory->getTagService() instanceof TagService);
        $this->assertTrue($serviceFactory->getTaxRate() instanceof TaxRateService);
        $this->assertTrue($serviceFactory->getUser() instanceof UserService);
    }
}
