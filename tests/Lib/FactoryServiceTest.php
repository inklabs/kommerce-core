<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Service;

class FactoryServiceTest extends Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->setupEntityManager();
    }

    public function testGetInstance()
    {
        $factoryService = FactoryService::getInstance($this->repository(), new CartCalculator(new Pricing));
        $this->assertTrue($factoryService instanceof FactoryService);
    }

    public function testGetServices()
    {
        $factoryService = $this->service(new CartCalculator(new Pricing));
        $this->assertTrue($factoryService->getAttribute() instanceof Service\Attribute);
        $this->assertTrue($factoryService->getAttributeValue() instanceof Service\AttributeValue);
        $this->assertTrue($factoryService->getCart() instanceof Service\Cart);
        $this->assertTrue($factoryService->getCartPriceRule() instanceof Service\CartPriceRule);
        $this->assertTrue($factoryService->getCatalogPromotion() instanceof Service\CatalogPromotion);
        $this->assertTrue($factoryService->getCoupon() instanceof Service\Coupon);
        $this->assertTrue($factoryService->getImage() instanceof Service\Image);
        $this->assertTrue($factoryService->getImportOrder() instanceof Service\Import\Order);
        $this->assertTrue($factoryService->getImportOrderItem() instanceof Service\Import\OrderItem);
        $this->assertTrue($factoryService->getImportPayment() instanceof Service\Import\Payment);
        $this->assertTrue($factoryService->getImportUser() instanceof Service\Import\User);
        $this->assertTrue($factoryService->getOrder() instanceof Service\Order);
        $this->assertTrue($factoryService->getProduct() instanceof Service\Product);
        $this->assertTrue($factoryService->getTag() instanceof Service\Tag);
        $this->assertTrue($factoryService->getTaxRate() instanceof Service\TaxRate);
        $this->assertTrue($factoryService->getUser() instanceof Service\User);
    }
}
