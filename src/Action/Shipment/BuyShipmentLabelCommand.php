<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class BuyShipmentLabelCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $orderId;

    /** @var OrderItemQtyDTO */
    private $orderItemQtyDTO;

    /** @var string */
    private $comment;

    /** @var string */
    private $shipmentExternalId;

    /** @var string */
    private $rateExternalId;

    public function __construct(
        string $orderId,
        OrderItemQtyDTO $orderItemQtyDTO,
        string $comment,
        string $shipmentExternalId,
        string $rateExternalId
    ) {
        $this->orderId = Uuid::fromString($orderId);
        $this->orderItemQtyDTO = $orderItemQtyDTO;
        $this->comment = $comment;
        $this->shipmentExternalId = $shipmentExternalId;
        $this->rateExternalId = $rateExternalId;
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function getShipmentExternalId(): string
    {
        return $this->shipmentExternalId;
    }

    public function getRateExternalId(): string
    {
        return $this->rateExternalId;
    }

    public function getOrderItemQtyDTO(): OrderItemQtyDTO
    {
        return $this->orderItemQtyDTO;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}
