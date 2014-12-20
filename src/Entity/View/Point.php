<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Point
{
    public $latitude;
    public $longitude;

    public function __construct(Entity\Point $point)
    {
        $this->latitude = $point->getLatitude();
        $this->longitude = $point->getLongitude();
    }
}
