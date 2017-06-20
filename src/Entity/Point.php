<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Point implements ValidationInterface
{
    /** @var float|null */
    protected $latitude;

    /** @var float|null */
    protected $longitude;

    public function __construct(float $latitude = null, float $longitude = null)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('latitude', new Assert\Range([
            'min' => -90,
            'max' => 90,
        ]));

        $metadata->addPropertyConstraint('longitude', new Assert\Range([
            'min' => -180,
            'max' => 180,
        ]));
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @param int $rangeInMiles
     * @return Point[]
     */
    public function getGeoBox(int $rangeInMiles): array
    {
        $milesOffset = ($rangeInMiles / 69.09);
        $latitudeUpperLeft    = round(($this->latitude - $milesOffset), 7);
        $latitudeBottomRight  = round(($this->latitude + $milesOffset), 7);
        $longitudeUpperLeft   = round(($this->longitude - $milesOffset), 7);
        $longitudeBottomRight = round(($this->longitude + $milesOffset), 7);

        $upperLeft = new Point($latitudeUpperLeft, $longitudeUpperLeft);
        $bottomRight = new Point($latitudeBottomRight, $longitudeBottomRight);

        return [$upperLeft, $bottomRight];
    }
}
