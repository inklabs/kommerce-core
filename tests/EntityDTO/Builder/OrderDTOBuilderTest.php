<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OrderDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $order = $this->dummyData->getOrderFull();

        $orderDTO = $this->getDTOBuilderFactory()
            ->getOrderDTOBuilder($order)
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
