<?php
namespace inklabs\kommerce\EntityDTO;

class ParcelDTO
{
    use TimeDTOTrait;

    /** @var string */
    public $externalId;

    /** @var float */
    public $length;

    /** @var float */
    public $width;

    /** @var float */
    public $height;

    /** @var int */
    public $weight;

    /** @var string */
    public $predefinedPackage;
}
