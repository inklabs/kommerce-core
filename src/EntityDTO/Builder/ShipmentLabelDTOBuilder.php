<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentLabel;
use inklabs\kommerce\EntityDTO\ShipmentLabelDTO;

class ShipmentLabelDTOBuilder implements DTOBuilderInterface
{
    /** @var ShipmentLabel */
    protected $entity;

    /** @var ShipmentLabelDTO */
    protected $entityDTO;

    public function __construct(ShipmentLabel $shipmentLabel)
    {
        $this->entity = $shipmentLabel;

        $this->entityDTO = new ShipmentLabelDTO;
        $this->entityDTO->externalId = $this->entity->getExternalId();
        $this->entityDTO->resolution = $this->entity->getResolution();
        $this->entityDTO->size       = $this->entity->getSize();
        $this->entityDTO->type       = $this->entity->getType();
        $this->entityDTO->fileType   = $this->entity->getFileType();
        $this->entityDTO->url        = $this->entity->getUrl();
        $this->entityDTO->pdfUrl     = $this->entity->getPdfUrl();
        $this->entityDTO->epl2Url    = $this->entity->getEpl2Url();
        $this->entityDTO->zplUrl     = $this->entity->getZplUrl();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
