<?php
namespace inklabs\kommerce\tests\Helper\Lib\Handler;

use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\CouponServiceInterface;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\Service\UserServiceInterface;
use inklabs\kommerce\tests\Helper\Lib\FakeCommand;

class FakeHandler
{
    public function __construct(
        TagServiceInterface $tagServiceInterface,
        ImageServiceInterface $imageServiceInterface,
        CartCalculatorInterface $cartCalculator,
        CartServiceInterface $cartServiceInterface,
        CouponServiceInterface $couponServiceInterface,
        OrderServiceInterface $orderServiceInterface,
        Pricing $pricing,
        ProductServiceInterface $productServiceInterface,
        ShipmentGatewayInterface $shipmentGatewayInterface,
        UserServiceInterface $userServiceInterface
    ) {
    }

    public function handle(FakeCommand $command)
    {
    }
}
