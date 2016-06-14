<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\UuidInterface;

final class AddShipmentTrackingCodeCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $orderId;

    /** @var OrderItemQtyDTO */
    private $orderItemQtyDTO;

    /** @var string */
    private $comment;

    /** @var int */
    private $carrier;

    /** @var string */
    private $trackingCode;

    /**
     * @param UuidInterface $orderId
     * @param OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param int $carrier ShipmentTracker::$carrier
     * @param string $trackingCode
     */
    public function __construct(
        UuidInterface $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        $comment,
        $carrier,
        $trackingCode
    ) {
        $this->orderId = $orderId;
        $this->orderItemQtyDTO = $orderItemQtyDTO;
        $this->comment = (string) $comment;
        $this->carrier = (int) $carrier;
        $this->trackingCode = (string) $trackingCode;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getOrderItemQtyDTO()
    {
        return $this->orderItemQtyDTO;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function getTrackingCode()
    {
        return $this->trackingCode;
    }
}
