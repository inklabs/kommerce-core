<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\PointDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use inklabs\kommerce\View;

class Point implements ValidationInterface
{
    protected $latitude;
    protected $longitude;

    public function __construct($latitude = null, $longitude = null)
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

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @param int $rangeInMiles
     * @return Point[]
     */
    public function getGeoBox($rangeInMiles)
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

    public function getView()
    {
        return new View\Point($this);
    }

    public function getDTOBuilder()
    {
        return new PointDTOBuilder($this);
    }
}
