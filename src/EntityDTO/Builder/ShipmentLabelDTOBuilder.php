<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentLabel;
use inklabs\kommerce\EntityDTO\ShipmentLabelDTO;

class ShipmentLabelDTOBuilder
{
    /** @var ShipmentLabel */
    private $shipmentLabel;

    public function __construct(ShipmentLabel $shipmentLabel)
    {
        $this->shipmentLabel = $shipmentLabel;

        $this->shipmentLabelDTO = new ShipmentLabelDTO;
        $this->shipmentLabelDTO->externalId = $this->shipmentLabel->getExternalId();
        $this->shipmentLabelDTO->resolution = $this->shipmentLabel->getResolution();
        $this->shipmentLabelDTO->size       = $this->shipmentLabel->getSize();
        $this->shipmentLabelDTO->type       = $this->shipmentLabel->getType();
        $this->shipmentLabelDTO->fileType   = $this->shipmentLabel->getFileType();
        $this->shipmentLabelDTO->url        = $this->shipmentLabel->getUrl();
        $this->shipmentLabelDTO->pdfUrl     = $this->shipmentLabel->getPdfUrl();
        $this->shipmentLabelDTO->epl2Url    = $this->shipmentLabel->getEpl2Url();
        $this->shipmentLabelDTO->zplUrl     = $this->shipmentLabel->getZplUrl();
    }

    public function build()
    {
        return $this->shipmentLabelDTO;
    }
}
