<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\EntityDTO\ParcelDTO;

class ParcelDTOBuilder
{
    /** @var Parcel */
    private $parcel;

    /** @var ParcelDTO */
    public $parcelDTO;

    public function __construct(Parcel $parcel)
    {
        $this->parcel = $parcel;

        $this->parcelDTO = new ParcelDTO;
        $this->parcelDTO->created    = $this->parcel->getCreated();
        $this->parcelDTO->updated    = $this->parcel->getUpdated();
        $this->parcelDTO->updated    = $this->parcel->getUpdated();
        $this->parcelDTO->externalId = $this->parcel->getExternalId();
        $this->parcelDTO->length     = $this->parcel->getLength();
        $this->parcelDTO->width      = $this->parcel->getWidth();
        $this->parcelDTO->height     = $this->parcel->getHeight();
        $this->parcelDTO->weigth     = $this->parcel->getWeight();
        $this->parcelDTO->predefinedPackage = $this->parcel->getPredefinedPackage();
    }

    public function build()
    {
        return $this->parcelDTO;
    }
}
