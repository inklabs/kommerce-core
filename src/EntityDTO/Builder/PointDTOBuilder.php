<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\EntityDTO\PointDTO;

class PointDTOBuilder
{
    /** @var Point */
    private $point;

    /** @var PointDTO */
    private $pointDTO;

    public function __construct(Point $point)
    {
        $this->point = $point;

        $this->pointDTO = new PointDTO;
        $this->pointDTO->latitude = $this->point->getLatitude();
        $this->pointDTO->longitude = $this->point->getLongitude();
    }

    public function build()
    {
        return $this->pointDTO;
    }
}
