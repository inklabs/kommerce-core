<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
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

    public function __construct(
        string $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        string $comment,
        int $carrier,
        string $trackingCode
    ) {
        $this->orderId = Uuid::fromString($orderId);
        $this->orderItemQtyDTO = $orderItemQtyDTO;
        $this->comment = $comment;
        $this->carrier = $carrier;
        $this->trackingCode = $trackingCode;
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function getOrderItemQtyDTO(): OrderItemQtyDTO
    {
        return $this->orderItemQtyDTO;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCarrier(): int
    {
        return $this->carrier;
    }

    public function getTrackingCode(): string
    {
        return $this->trackingCode;
    }
}
