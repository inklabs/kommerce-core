<?php
namespace inklabs\kommerce\Entity;

class Point
{
    protected $latitude;
    protected $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = (float) $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = (float) $longitude;
    }

    /**
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
}
