<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Point implements ViewInterface
{
    public $latitude;
    public $longitude;

    public function __construct(Entity\Point $point)
    {
        $this->latitude = $point->getLatitude();
        $this->longitude = $point->getLongitude();
    }

    public function export()
    {
        return $this;
    }
}
