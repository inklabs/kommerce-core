<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper;

class OrderDTOBuilderTest extends Helper\DoctrineTestCase
{
    public function testBuild()
    {
        $orderItem = $this->dummyData->getOrderItemFull();

        $order = new Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new CartTotal);
        $order->setShippingAddress(new OrderAddress);
        $order->setBillingAddress(new OrderAddress);
        $order->setUser(new User);
        $order->addCoupon(new Coupon);
        $order->addPayment(new CashPayment(100));
        $order->addShipment(new Shipment);
        $order->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $order->setTaxRate(new TaxRate);

        $orderDTO = $order->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderDTO instanceof OrderDTO);
        $this->assertTrue($orderDTO->shippingAddress instanceof OrderAddressDTO);
        $this->assertTrue($orderDTO->billingAddress instanceof OrderAddressDTO);
        $this->assertTrue($orderDTO->total instanceof CartTotalDTO);
        $this->assertTrue($orderDTO->user instanceof UserDTO);

        $orderItemDTO = $orderDTO->orderItems[0];
        $this->assertTrue($orderItemDTO instanceof OrderItemDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionProducts[0] instanceof OrderItemOptionProductDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionProducts[0]->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionProducts[0]->optionProduct->option instanceof OptionDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionValues[0] instanceof OrderItemOptionValueDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionValues[0]->optionValue instanceof OptionValueDTO);
        $this->assertTrue($orderItemDTO->orderItemOptionValues[0]->optionValue->option instanceof OptionDTO);
        $this->assertTrue($orderItemDTO->orderItemTextOptionValues[0] instanceof OrderItemTextOptionValueDTO);
        $this->assertTrue($orderItemDTO->orderItemTextOptionValues[0]->textOption instanceof TextOptionDTO);

        $this->assertTrue($orderDTO->payments[0] instanceof AbstractPaymentDTO);
        $this->assertTrue($orderDTO->coupons[0] instanceof CouponDTO);
        $this->assertTrue($orderDTO->shipments[0] instanceof ShipmentDTO);
        $this->assertTrue($orderDTO->shipmentRate instanceof ShipmentRateDTO);
        $this->assertTrue($orderDTO->taxRate instanceof TaxRateDTO);
    }
}
