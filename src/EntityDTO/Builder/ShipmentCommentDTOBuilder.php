<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\EntityDTO\ShipmentCommentDTO;
use inklabs\kommerce\Lib\BaseConvert;

class ShipmentCommentDTOBuilder
{
    /** @var ShipmentComment */
    private $shipmentComment;

    public function __construct(ShipmentComment $shipmentComment)
    {
        $this->shipmentComment = $shipmentComment;

        $this->shipmentCommentDTO = new ShipmentCommentDTO;
        $this->shipmentCommentDTO->id              = $this->shipmentComment->getId();
        $this->shipmentCommentDTO->encodedId       = BaseConvert::encode($this->shipmentComment->getId());
        $this->shipmentCommentDTO->created         = $this->shipmentComment->getCreated();
        $this->shipmentCommentDTO->updated         = $this->shipmentComment->getUpdated();

        $this->shipmentCommentDTO->comment         = $this->shipmentComment->getComment();
    }

    public function build()
    {
        return $this->shipmentCommentDTO;
    }
}
