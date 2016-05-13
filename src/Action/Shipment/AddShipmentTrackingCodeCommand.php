<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class AddShipmentTrackingCodeCommand implements CommandInterface
{
    /** @var int */
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
     * @param int $orderId
     * @param OrderItemQtyDTO $orderItemQtyDTO
     * @param string $comment
     * @param int $carrier ShipmentTracker::$carrier
     * @param string $trackingCode
     */
    public function __construct(
        $orderId,
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
